<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provincia;
use App\Models\Cursos\Curso;
use App\Reporte;
use App\Periodo;
use DB;
use Log;
use Excel;
use PDF;
use Auth;
use Datatables;
use Cache;

class ReportesController extends Controller
{
    public function get()
    {
        return view('reportes', $this->getSelectOptions());
    }

    /**
     * Opciones para los selects del front end.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSelectOptions()
    {
        $provincias = Cache::remember('provincias', 5, function () {
            return Provincia::all();
        });

        $periodos = Cache::remember('periodos', 5, function () {
            return Periodo::all();
        });

        return array(
            'provincias' => $provincias,
            'periodos' => $periodos
            );
    }

    public function getCursos()
    {
        return $this->reporte(5);
    }

    public function efectores(Request $r)
    {     
        return $this->reporte(6);
    }

    public function reporte($id_reporte)
    {
        $reporte = Reporte::findOrFail($id_reporte);        

        $provincia_usuario = Provincia::findOrFail(Auth::user()->id_provincia);

        $extra = array(
            'reporte' => $reporte,
            'provincia_usuario' => $provincia_usuario
            );

        $data = array_merge($this->getSelectOptions(),$extra);

        logger(json_encode($data));

        return view('reportes.'.$reporte->view, $data);
    }

    public function queryReporte(Request $r)
    {
        $query = $this->queryLogica($r);

        $returns = DB::select($query);

        return Datatables::of(collect($returns))->make(true);

        /*return Datatables::of($query)->make(true);*/
    }

    private function queryLogica(Request $r)
    {
        logger("Reporte: ".json_encode($r->only(['id_reporte','filtros','order_by']),2));

        $id_reporte = $r->id_reporte;

        $id_provincia = array_key_exists('id_provincia', $r->filtros)?
        $r->filtros['id_provincia']:Auth::user()->id_provincia;

        if (array_key_exists('id_periodo', $r->filtros)) {
            $id_periodo = $r->filtros['id_periodo'];
        } else if (array_key_exists('desde', $r->filtros) && array_key_exists('hasta', $r->filtros)) {
            $desde = $r->filtros['desde'];
            $hasta = $r->filtros['hasta'];
        }

        if (!array_key_exists('id_periodo', $r->filtros)) {

            $query = "SELECT CONCAT('{$desde}'::date,'/','{$hasta}'::date) as periodo,* 
            FROM reporte_{$r->id_reporte}('{$id_provincia}','{$desde}','{$hasta}')";

        } elseif ($id_reporte == '5' and $id_periodo == '0') {

            $query = "SELECT P.nombre as periodo ,R.* 
            FROM sistema.periodos P,reporte_{$id_reporte}({$id_provincia},P.desde,P.hasta) R order by P.id_periodo,R.provincia,R.nombre,R.edicion";

        } elseif ($id_periodo == '0') {

            $query = "SELECT P.nombre as periodo ,R.* 
            FROM sistema.periodos P,reporte_{$id_reporte}({$id_provincia},P.desde,P.hasta) R";

        } else {

            $query = "SELECT P.nombre as periodo ,R.*
            FROM sistema.periodos P,reporte_{$id_reporte}({$id_provincia},P.desde,P.hasta) R 
            where P.id_periodo = {$id_periodo}";    

            /*$query = DB::table("sistema.periodos as pe,reporte_{$id_reporte}({$id_provincia},pe.desde,pe.hasta) as r")
        ->select('pe.nombre as periodo','r.*')
        ->where('pe.id_periodo',$id_periodo);  */      

        }

        return $query;
    }

    public function getExcelReporte(Request $r)
    {
        $reporte = Reporte::findOrFail($r->id_reporte);
        $query_default = $this->queryLogica($r);
        $nombre_reporte = $reporte->view;

        $excel_reporte = "excel.reporte_".$r->id_reporte;

        $data = DB::select($query_default);
        $datos = ['resultados' => $data,'nombre' => $excel_reporte];
        $path = $nombre_reporte."_".date("Y-m-d_H:i:s");

        Excel::create(
            $path,
            function ($excel) use ($datos) {
                $excel->sheet(
                    'Reporte',
                    function ($sheet) use ($datos) {
                        $sheet->setHeight(1, 20);
                        $sheet->loadView($datos['nombre'], $datos);
                    }
                );
            }
        )
        ->store('xls');

        return $path;
    }

    public function getPDFReporte(Request $r)
    {
        $reporte = Reporte::find($r->id_reporte);
        $query_default = $this->queryLogica($r);
        $nombre_reporte = $reporte->view;

        $pdf_reporte = "excel.reporte_".$r->id_reporte;

        $data = DB::select($query_default);
        $datos = ['resultados' => $data];
        $path = $nombre_reporte."_".date("Y-m-d_H:i:s");

        $pdf = PDF::loadView($pdf_reporte, $datos)->save($path.".pdf");

        return $path;
    }

    public function reporte5($id_provincia = '0',$desde = '2014-01-01',$hasta = '2014-12-31')
    {
        $query = DB::table('sistema.provincias as p')
        ->leftJoin('efectores.datos_geograficos as dg',DB::raw('dg.id_provincia::integer'),'=','p.id_provincia')
        ->join('efectores.efectores as e','e.id_efector','=','dg.id_efector')
        ->join('efectores.compromiso_gestion as cg','cg.id_efector','=','e.id_efector')
        ->join('alumnos.alumnos as a','a.establecimiento1','=','e.cuie')
        ->join('cursos.cursos_alumnos as ca','ca.id_alumno','=','a.id_alumno')
        ->join('cursos.cursos as c','c.id_curso','=','c.id_curso')
        ->select('p.nombre as provincia',DB::raw('count(distinct e.cuie) as capacitados'))
        ->whereBetween('c.fecha',[$desde,$hasta])
        ->groupBy('p.nombre');

        if ($id_provincia != '0') {
            $query = $query->where('p.id_provincia',$id_provincia);
        }

        return $query;
    }

    public function test($id_provincia = '0',$desde = '2014-01-01',$hasta = '2014-12-31',$id_periodo = 4,$id_reporte = 6)
    {
        return DB::table("sistema.periodos as pe")
        ->join(DB::raw("reporte_{$id_reporte}({$id_provincia},pe.desde,pe.hasta) as r"))
        ->select('pe.nombre as periodo','r.*')
        ->where('pe.id_periodo',$id_periodo);
    }
}