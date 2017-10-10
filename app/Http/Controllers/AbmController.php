<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Log;
use App\TipoDocumento;

abstract class AbmController extends Controller
{

    private $excepto = array('created_at','updated_at','deleted_at','id');

    public function query($query)
    {
        return DB::connection('eLearning')->select($query);
    }

    public function filtros($tabla)
    {
        $r = DB::select(
            "SELECT column_name
            FROM information_schema.columns
            WHERE table_schema = 'public'
            AND table_name   = '{$tabla}';"
        );
        
        $ret = collect($r);

        $filtered = $ret->filter(
            function ($value, $key) {
                foreach ($value as $column => $name) {
                    return !in_array($name, $this->excepto);
                }
            }
        )->map(
            function ($value, $key) {
                foreach ($value as $column => &$name) {
                    $name = ucfirst($name);
                    return $value;
                }
            }
        );

        return $filtered;
    }

    public function formularioConFiltros($tabla)
    {
        return view('formulario', ['columnas' => json_decode($this->filtros($tabla), true)]);
    }

    /**
     *   Quiero agregar que columnas de la tabla necesitan tranformarse en un cuadro de seleccion e ir a buscar en la tabla los valores que corresponda
     */

    public function tiposDocumentos()
    {
        return TipoDocumento::all();
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
        return response()->json(
            array(
            'status' => true,
            'error' => null,
            'data' => array(
                'info' => $info
                )
            )
        );
    }
}
