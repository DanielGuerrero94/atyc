<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursos\Curso;
use DB;
use Auth;
use Datatables;

class EfectoresController extends Controller
{
    public function get()
    {
        return view('efectores');
    }

    public function queryLogica()
    {
        return DB::table('efectores.efectores as e')
        ->join('efectores.datos_geograficos as dg', 'dg.id_efector', '=', 'e.id_efector')
        ->leftJoin('geo.provincias as p', 'p.id_provincia', '=', 'dg.id_provincia')
        ->leftJoin('geo.departamentos as d', 'd.id', '=', 'dg.id_departamento')
        ->leftJoin('geo.localidades as l', 'l.id', '=', 'dg.id_localidad')
        ->select('p.descripcion as provincia', 'e.siisa', 'e.cuie', 'e.nombre', 'e.denominacion_legal', 'e.domicilio', 'd.nombre_departamento as departamento', 'l.nombre_localidad as localidad', 'e.codigo_postal', 'dg.ciudad');
    }

    public function reporte()
    {
        $desde = '2017-01-01';
        $hasta = '2017-12-31';
        $provincia = '24';


        return DB::table('efectores.efectores as e')
        ->join('efectores.datos_geograficos as dg', 'dg.id_efector', '=', 'e.id_efector')
        ->join('geo.provincias as p', 'p.id_provincia', '=', 'dg.id_provincia')
        ->join('geo.departamentos as d', 'd.id', '=', 'dg.id_departamento')
        ->join('geo.localidades as l', 'l.id', '=', 'dg.id_localidad')
        ->join('alumnos.alumnos as a', 'a.establecimiento1', '=', 'e.cuie')        
        ->join('cursos.cursos_alumnos as ca', 'ca.id_alumno', '=', 'a.id_alumno')
        ->join('cursos.cursos as c', 'c.id_curso', '=', 'ca.id_curso')
        ->rightJoin('sistema.periodos as pe', function ($join){
            return $join->whereBetween('c.fecha',[DB::raw('to_date(pe.desde::text,\'YYYY-MM-DD\')'),DB::raw('to_date(pe.hasta::text,\'YYYY-MM-DD\')')]);
        })
        //->crossJoin('sistema.periodos as pe')
        ->select('pe.nombre as periodo', 'p.descripcion as provincia', 'e.cuie', 'e.nombre as efector', 'e.denominacion_legal', 'd.nombre_departamento as departamento', 'l.nombre_localidad as localidad', 'c.nombre as accion', 'c.fecha',DB::raw('count(*) as participantes'))
        //->whereBetween(DB::raw('c.fecha between pe.desde and pe.hasta'))
        //->where(DB::raw('c.fecha between pe.desde and pe.hasta'))
        //->where('dg.id_provincia',$provincia)
        ->groupBy('pe.nombre', 'p.descripcion', 'e.cuie', 'e.nombre', 'e.denominacion_legal', 'd.nombre_departamento', 'l.nombre_localidad', 'c.nombre', 'c.fecha');

        /*return DB::table('efectores.efectores as e')
        ->join('efectores.datos_geograficos as dg', 'dg.id_efector', '=', 'e.id_efector')
        ->join('geo.provincias as p', 'p.id_provincia', '=', 'dg.id_provincia')
        ->join('geo.departamentos as d', 'd.id', '=', 'dg.id_departamento')
        ->join('geo.localidades as l', 'l.id', '=', 'dg.id_localidad')
        ->join('alumnos.alumnos as a', 'a.establecimiento1', '=', 'e.cuie')        
        ->join('cursos.cursos_alumnos as ca', 'ca.id_alumno', '=', 'a.id_alumno')
        ->join('cursos.cursos as c', 'c.id_curso', '=', 'ca.id_curso')
        ->select('p.descripcion as provincia', 'e.cuie', 'e.nombre as efector', 'e.denominacion_legal', 'd.nombre_departamento as departamento', 'l.nombre_localidad as localidad', 'c.nombre as accion', 'c.fecha',DB::raw('count(*) as participantes'))
        ->whereBetween('c.fecha',[$desde,$hasta])
        ->where('dg.id_provincia',$provincia)
        ->groupBy('p.descripcion', 'e.cuie', 'e.nombre', 'e.denominacion_legal', 'd.nombre_departamento', 'l.nombre_localidad', 'c.nombre', 'c.fecha');*/
    }

    public function getTabla()
    {
        $query = $this->queryLogica();

        return Datatables::of($query)
        ->addColumn('acciones', function ($ret) {
            $ver_historial = '<a href="efectores/'.$ret->cuie.'/cursos"><button class="btn btn-info" title="Historial"><i class="fa fa-calendar" aria-hidden="true"></i> Historial</button></a>';
            return $ver_historial;
        })
        ->make(true);
    }

    public function toTypeahead($array)
    {
        return array(
            'status' => true,
            'error' => null,
            'data' => $array
            );
    }

    public function nombresTypeahead(Request $r)
    {
        return $this->toTypeahead(
            array(
                'nombres' => $this->getNombres($r)
                )
            );
    }

    public function cuiesTypeahead(Request $r)
    {
        return $this->toTypeahead(
            array(
                'cuies' => $this->getCuies($r)
                )
            );
    }

    public function getNombres(Request $r)
    {
        $query = DB::table('efectores.efectores as e')
        ->join('efectores.datos_geograficos as dg', 'e.id_efector', '=', 'dg.id_efector')
        ->select('e.nombre')
        ->where('e.nombre','ilike','%'.$r->q.'%')
        ->orderBy('e.nombre');

        return $this->segunProvincia($query,$r->id_provincia)
        ->get()
        ->map(function ($item, $key) {
            return $item->nombre;
        })
        ->toArray();
    }

    public function getCuies(Request $r)
    {
        $query = DB::table('efectores.efectores as e')
        ->join('efectores.datos_geograficos as dg', 'e.id_efector', '=', 'dg.id_efector')
        ->select('e.cuie')
        ->where('e.cuie','ilike','%'.$r->q.'%')
        ->orderBy('e.cuie');

        return $this->segunProvincia($query,$r->id_provincia)    
        ->get()
        ->map(function ($item, $key) {
            return $item->cuie;
        })
        ->toArray();
    }



    public function segunProvincia($query,$id_provincia)
    {
        if ($id_provincia != 0) {

            $id_provincia = $id_provincia < 10?"0".strval($id_provincia):strval($id_provincia);

            $query = $query->where('dg.id_provincia', $id_provincia);
        }

        return $query;
    }

    public function historialCursos($cuie)
    {
        $efector = $this->queryLogica();

        $provincia = Auth::user()->id_provincia;

        if ($provincia != 25) {
            $efector = $efector
            ->where('dg.id_provincia', $provincia);
        }

        $efector = $efector
        ->where('e.cuie', $cuie)
        ->first();

        $cursos = Curso::getByCuie($cuie);

        $array = array('efector' => $efector,'cursos' => $cursos);
        return view('efectores/historial_cursos', $array);
    }

    public function findCuie($string)
    {
        if($this->esCuie($string)){
            return $string;
        }

        $efector = DB::table('efectores.efectores as e')
        ->select('e.cuie')
        ->where('e.nombre',$string)
        ->first();

        return $efector?$efector->cuie:$efector;
    }

    /**
     * Podria ser mas especifico y armar una regex para las letras que hay en los cuies no para todas  
     * 
     * @param 
     */
    public function esCuie($string)
    {
        return preg_match('/[A-HJ-NP-Z][0-9]{5}/', $string);
    }
}