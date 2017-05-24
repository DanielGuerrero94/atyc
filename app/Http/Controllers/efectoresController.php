<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curso;
use DB;
use Auth;
use Datatables;

class efectoresController extends Controller
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
        return $this->query()
        ->table('efectores')
        ->join('datos_geograficos','datos_geograficos.id_efector','=','efectores.id_efector')
        ->leftJoin('geo.provincias','geo.provincias.id_provincia','=','datos_geograficos.id_provincia')
        ->leftJoin('geo.departamentos','geo.departamentos.id','=','datos_geograficos.id_departamento')
        ->leftJoin('geo.localidades','geo.localidades.id','=','datos_geograficos.id_localidad')
        ->select('geo.provincias.descripcion AS provincia','efectores.siisa','efectores.cuie','efectores.nombre','efectores.denominacion_legal','efectores.domicilio','geo.departamentos.nombre_departamento AS departamento', 'geo.localidades.nombre_localidad AS localidad','efectores.codigo_postal','datos_geograficos.ciudad');
    }

    public function getTabla()
    {
        $returns = $this->queryLogica()->get();

        return Datatables::of($returns)->addColumn('acciones' , function($ret){
            $ver_historial = '<a href="efectores/'.$ret->cuie.'/cursos"><button class="btn btn-info" title="Historial"><i class="fa fa-calendar" aria-hidden="true"></i> Historial</button></a>';         
            return $ver_historial;
        })            
        ->make(true);  
    }

    public function getTripleTypeahead()
    {
        $ret = array(
            'status' => true,
            'error' => null,
            'data' => array(
                'nombres' => $this->getNombres(),
                'cuies' => $this->getCuies()
                /*'siisas' => $this->getSiisas()*/
                )
            );

        return json_encode($ret);
    }

    public function getNombres()
    {   
        $query = $this->query()
        ->table('efectores')
        ->join('datos_geograficos','efectores.id_efector','=','datos_geograficos.id_efector')
        ->select('efectores.nombre');

        if(Auth::user()->id_provincia != 25){
            $query = $query->where('datos_geograficos.id_provincia','=',Auth::user()->id_provincia);
        }

        return $query->orderBy('efectores.nombre')
        ->get()
        ->map(function($item,$key){
            return $item->nombre;
        });        
    }

    public function getCuies()
    {  
        $query = $this->query()
        ->table('efectores')
        ->select('cuie');

        if(Auth::user()->id_provincia != 25){
            $query = $query->where('datos_geograficos.id_provincia','=',Auth::user()->id_provincia);
        }

        return $query->orderBy('cuie')
        ->get()
        ->map(function($item,$key){
            return $item->cuie;
        });
    }

    /*public function getSiisas()
    {   
        $query = "SELECT siisa FROM efectores ORDER BY siisa";
        $siisas = $this->query($query);
        $siisas = collect($siisas);

        $arrayMapeado = $siisas->map(function($item,$key)
        {
            return $item->siisa;
        });

        return $arrayMapeado;
    }*/

    public function historialCursos($cuie)
    {   
        $efector = $this->queryLogica();

        if(Auth::user()->id_provincia != 25){
            $efector = $efector
            ->where('datos_geograficos.id_provincia','=',Auth::user()->id_provincia);
        }
        
        $efector = $efector
        ->where('efectores.cuie','=',$cuie)
        ->first();

        $cursos = Curso::getByCuie($cuie);

        $array = array('efector' => $efector,'cursos' => $cursos);
        return view('efectores/historial_cursos',$array);
    }    
}
