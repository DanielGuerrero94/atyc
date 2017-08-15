<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursos\Curso;
use DB;
use Auth;
use Datatables;

class EfectoresController extends Controller
{
    public function rawQuery($query)
    {
        return DB::connection('efectores')->select($query);
    }

    public function query()
    {
        return DB::connection('efectores');
    }

    public function get()
    {
        return view('efectores');
    }

    public function queryLogica()
    {
        return DB::table('efectores.efectores')
        ->join('efectores.datos_geograficos', 'datos_geograficos.id_efector', '=', 'efectores.id_efector')
        ->leftJoin('geo.provincias', 'geo.provincias.id_provincia', '=', 'datos_geograficos.id_provincia')
        ->leftJoin('geo.departamentos', 'geo.departamentos.id', '=', 'datos_geograficos.id_departamento')
        ->leftJoin('geo.localidades', 'geo.localidades.id', '=', 'datos_geograficos.id_localidad')
        /*->join('alumnos.alumnos', 'alumnos.alumnos.establecimiento1', '=', 'efectores.efectores.cuie')*/
        ->select('geo.provincias.descripcion AS provincia', 'efectores.siisa', 'efectores.cuie', 'efectores.nombre', 'efectores.denominacion_legal', 'efectores.domicilio', 'geo.departamentos.nombre_departamento AS departamento', 'geo.localidades.nombre_localidad AS localidad', 'efectores.codigo_postal', 'datos_geograficos.ciudad');
            /*return DB::select("select gp.descripcion AS provincia, e.siisa,e.cuie,e.nombre,e.denominacion_legal,e.domicilio,gd.nombre_departamento AS departamento, gl.nombre_localidad AS localidad,e.codigo_postal,d.ciudad 
        from efectores.efectores e
        join efectores.datos_geograficos d on d.id_efector = e.id_efector
        left join geo.provincias gp on gp.id_provincia = d.id_provincia
        left join geo.departamentos gd on gd.id = d.id_departamento
        left join geo.localidades gl on gl.id = d.id_localidad
        inner join alumnos.alumnos a on a.establecimiento1 = e.cuie");*/
    }

    public function getTabla()
    {
        $query = $this->queryLogica();

        return Datatables::of($query)->addColumn(
            'acciones',
            function ($ret) {
                $ver_historial = '<a href="efectores/'.$ret->cuie.'/cursos"><button class="btn btn-info" title="Historial"><i class="fa fa-calendar" aria-hidden="true"></i> Historial</button></a>';
                return $ver_historial;
            }
            )
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
        $query = DB::table('efectores.efectores')
        ->join('efectores.datos_geograficos', 'efectores.efectores.id_efector', '=', 'efectores.datos_geograficos.id_efector')
        ->select('efectores.efectores.nombre')
        ->where('efectores.efectores.nombre','ilike','%'.$r->q.'%')
        ->orderBy('efectores.efectores.nombre');

        return $this->segunProvincia($query,$r->id_provincia)
        ->get()
        ->map(function ($item, $key) {
            return $item->nombre;
        })
        ->toArray();
    }

    public function getCuies(Request $r)
    {
        $query = DB::table('efectores.efectores')
        ->join('efectores.datos_geograficos', 'efectores.efectores.id_efector', '=', 'efectores.datos_geograficos.id_efector')
        ->select('efectores.efectores.cuie')
        ->where('efectores.efectores.cuie','ilike','%'.$r->q.'%')
        ->orderBy('efectores.efectores.cuie');

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

            $query = $query->where('efectores.datos_geograficos.id_provincia', $id_provincia);
        }

        return $query;
    }

    public function historialCursos($cuie)
    {
        $efector = $this->queryLogica();

        $provincia = Auth::user()->id_provincia;

        if ($provincia != 25) {
            $efector = $efector
            ->where('datos_geograficos.id_provincia', $provincia);
        }

        $efector = $efector
        ->where('efectores.cuie', $cuie)
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

        $efector = DB::table('efectores.efectores')
        ->select('efectores.efectores.cuie')
        ->where('efectores.efectores.nombre',$string)
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