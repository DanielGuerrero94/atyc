<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\AreaTematica;
use Log;
use Validator;
use Datatables;

class areasTematicasController extends Controller
{
    private 
    $_rules = [
    'nombre' => 'required|string'
    ];

    public function getTodos()
    {
    	return view('areasTematicas');
    }

    
    public function getTabla()
    {
    	Log::info('Entre a buscar la tabla.');
    	$returns = AreaTematica::table();
    	Log::info('Me devuelve'.$returns);
    	return Datatables::of($returns)
        ->addColumn('acciones' , function($ret){
            return '<button data-id="'.$ret->id_area_tematica.'" class="btn btn-info btn-xs editar" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'.'<button data-id="'.$ret->id_area_tematica.'" class="btn btn-danger btn-xs eliminar" title="Eliminar" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Some content"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';

        })            
        ->make(true);      
    }

    public function getAlta()
    {
        return view('areasTematicas/alta');
    }

    public function set(Request $r)
    {

        $area = new AreaTematica();
        $area->crear($r);
    }

    public function modificar(Request $r,$id)
    {
        $area = AreaTematica::find($id);
        $area->modificar($r);
    }

    public function get($id)
    {
        $area = AreaTematica::find($id);

        return view('areasTematicas/modificar',['area' => $area]);
    }

    //Puedo pedir que en el request me manden una razon para la baja
    public function borrar(Request $r,$id)
    {
        $area = AreaTematica::find($id);
        $area->delete();
    }
}
