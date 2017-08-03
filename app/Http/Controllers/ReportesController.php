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
    public function query($query)
    {
        return DB::connection('eLearning')->select($query);
    }

    public function get()
    {
        return view(
            'reportes',
            ['provincias' => Provincia::all(),
            'periodos' => Periodo::all()]
        );
    }

    public function getCursos()
    {
        $provincias = Cache::remember('provincias', 5, function () {
            return Provincia::all();
        });

        $provincia_usuario = Provincia::find(Auth::user()->id_provincia);

        return view(
            'reportes.cursos-cantidad-alumnos',
            [
            'provincias' => $provincias,
            'provincia_usuario' => $provincia_usuario
            ]
        );
    }

    public function reporte($id_reporte)
    {
        $reporte = Reporte::find($id_reporte);

        $provincias = Cache::remember('provincias', 5, function () {
            return Provincia::all();
        });

        $periodos = Cache::remember('periodos', 5, function () {
            return Periodo::all();
        });

        $provincia_usuario = Provincia::find(Auth::user()->id_provincia);

        return view(
            'reportes.'.$reporte->view,
            [
            'provincias' => $provincias,
            'periodos' => $periodos,
            'reporte' => $reporte,
            'provincia_usuario' => $provincia_usuario
            ]
        );
    }

    public function queryReporte(Request $r)
    {
        $query = $this->queryLogica($r);

        $returns = DB::select($query);

        return Datatables::of(collect($returns))->make(true);
    }

    private function queryLogica(Request $r)
    {
        logger("Reporte: ".json_encode($r->id_reporte));
        logger("Filtros: ".json_encode($r->filtros));
        logger("Order By: ".json_encode($r->order_by));
        /*Esta parte me quedo horrible voy a tener que reeverlo porque tengo demasiados if
        en el caso que no sea un periodo de los que hay en la tabla le concateno
        las fechas que me pasaron para la columna periodo
        */
        

        $id_provincia = in_array('id_provincia', $r->filtros)?
        $r->filtros['id_provincia']:Auth::user()->id_provincia;
        if ($id_provincia == 25) {
            $id_provincia = 0;
        }

        if (array_key_exists('desde', $r->filtros) && array_key_exists('hasta', $r->filtros)) {
            $query = "SELECT CONCAT('".$r->filtros['desde']."'::date,'/','".$r->filtros['hasta']."'::date) as periodo,* 
            FROM reporte_".$r->id_reporte."('".$id_provincia."','".$r->filtros['desde']."','".$r->filtros['hasta']."')";
        } elseif ($r->id_reporte == '4') {
            $query = "SELECT P.nombre as periodo ,R.provincia,R.capacitados,R.total,R.porcentaje 
            FROM sistema.periodos P,reporte_".$r->id_reporte."(".$id_provincia.",P.desde,P.hasta) R";
        } elseif ($r->filtros['id_periodo'] == '0') {
            $query = "SELECT P.nombre as periodo ,R.provincia,R.cantidad_alumnos 
            FROM sistema.periodos P,reporte_".$r->id_reporte."(".$id_provincia.",P.desde,P.hasta) R";
        } else {
            $query = "SELECT P.nombre as periodo ,R.provincia,R.cantidad_alumnos 
            FROM sistema.periodos P,reporte_".$r->id_reporte."(".$id_provincia.",P.desde,P.hasta) R 
            where P.id_periodo = ".$r->filtros['id_periodo'];
        }

        return $query;
    }

    public function queryTest(Request $r)
    {
        $query = "SELECT * FROM reporte_".$r->id_reporte.
        "('".Auth::user()->id_provincia."','".$r->desde."','".$r->hasta."')";

        $returns = DB::select($query);

        return Datatables::of($returns)->make(true);
    }

    public function getExcel()
    {
        $query = "SELECT C.nombre,C.edicion,C.fecha,count (*) as cantidad_alumnos,
        CONCAT(LE.numero,'-',LE.nombre) as linea_estrategica,AT.nombre as area_tematica,
        P.nombre as provincia,C.duracion 
        from cursos.cursos C 
		left join cursos.cursos_alumnos CA ON CA.id_cursos = C.id_curso 
		left join alumnos.alumnos A ON CA.id_alumnos = A.id_alumno
		inner join sistema.provincias P ON P.id_provincia = C.id_provincia
		inner join cursos.areas_tematicas AT ON AT.id_area_tematica = C.id_area_tematica 
		inner join cursos.lineas_estrategicas LE ON LE.id_linea_estrategica = C.id_linea_estrategica 
        group by C.id_curso,C.nombre,LE.numero,LE.nombre,AT.nombre,P.nombre
		order by C.nombre,C.edicion";

        $data = DB::select($query);
        $datos = ['cursos' => $data];
        logger($datos);

        Excel::create(
            'Cursos',
            function ($excel) use ($datos) {
                $excel->sheet(
                    'Tabla_cursos',
                    function ($sheet) use ($datos) {
                        $sheet->setHeight(1, 20);
                        $sheet->loadView('excel.generico', $datos);
                    }
                );
            }
        )
        ->store('xls');
        return response()->download('/var/www/html/atyc/storage/exports/Cursos.xls');
    }

    public function getPdf()
    {
        $query = "SELECT C.nombre,C.edicion,C.fecha,count (*) as cantidad_alumnos,
         CONCAT(LE.numero,'-',LE.nombre) as linea_estrategica,AT.nombre as area_tematica,
         P.nombre as provincia,C.duracion 
        from cursos C 
		left join cursos_alumnos CA ON CA.id_cursos = C.id 
		left join alumnos A ON CA.id_alumnos = A.id
		inner join provincias P ON P.id = C.id_provincia
		inner join area_tematicas AT ON AT.id = C.id_area_tematica 
		inner join linea_estrategicas LE ON LE.id = C.id_linea_estrategica
        group by C.id,C.nombre,LE.numero,LE.nombre,AT.nombre,P.nombre
		order by C.nombre,C.edicion
        limit 10";

        $data = DB::select($query);
        $datos = ['cursos' => $data];
        logger('Antes');
        $pdf = PDF::loadView('excel.generico', $datos)->download('generico.pdf');
        
        return $pdf;
    }

    public function getExcelReporte(Request $r)
    {
        $reporte = Reporte::find($r->id_reporte);
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
}
