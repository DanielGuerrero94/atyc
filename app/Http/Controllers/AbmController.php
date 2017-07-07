<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoDocumento;
use DB;
use Log;

class AbmController extends Controller
{

    private $excepto = array('created_at','updated_at','deleted_at','id');

    public function query($query)
    {
    	return DB::connection('eLearning')->select($query);
    }	

    public function filtros($tabla)
    {
    	/*$query = "SELECT column_name
        FROM information_schema.columns
        WHERE table_schema = 'g_plannacer'
        AND table_name   = '".$tabla."';";

        $ret = collect($this->query($query));*/

        $r = DB::select("SELECT column_name
            FROM information_schema.columns
            WHERE table_schema = 'public'
            AND table_name   = '".$tabla."';");
        
        /*Log::info("Query:".json_encode($r));*/

        $ret = collect($r);

/*        Log::info(json_encode($ret));*/

        $filtered = $ret->filter(function ($value,$key)
        {
            foreach ($value as $column => $name) {
                return !in_array($name,$this->excepto);
            } 
        })->map(function ($value,$key)
        {
            foreach ($value as $column => &$name) {
                $name = ucfirst($name);
                return $value;
            }    
        });

/*        Log::info(json_encode($ret));*/

        return json_encode($filtered);
    }

    public function formularioConFiltros($tabla)
    {
        Log::info($tabla);
    	return view('formulario',['columnas' => json_decode($this->filtros($tabla),true)]);
    }

    /**
    *   Quiero agregar que columnas de la tabla necesitan tranformarse en un cuadro de seleccion e ir a buscar en la tabla los valores que corresponda
    *
    */

    public function tiposDocumentos()
    {
        return json_encode(TipoDocumento::all());
    }

    public function filtrar(Request $r)
    {
        $tabla = $r->tabla;        
    }

    /**
     * Respuesta al typeahead.
     *
     * @return \Illuminate\Http\Response
     */
    protected function typeaheadResponse($info)
    {
        $ret = array(
            'status' => true,
            'error' => null,
            'data' => array(
                'info' => $info
                )
            );
        return json_encode($ret);
    }
    
}

