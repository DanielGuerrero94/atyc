<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LineaEstrategica;
use Log;
use Validator;
use Datatables;

class lineasEstrategicasController extends Controller
{
    private 
    $_rules = [
    'numero' => 'required|numeric',
    'nombre' => 'required|string'
    ];

    public function getTodos()
    {
      return view('lineasEstrategicas');    	
  }

  public function getTabla()
  {
    $returns = LineaEstrategica::table();       
    return Datatables::of($returns)
    ->addColumn('acciones' , function($ret){
        return '<button data-id="'.$ret->id.'" class="btn btn-info btn-xs editar" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'.'<button data-id="'.$ret->id.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
    })            
    ->make(true); 
}

public function getAlta()
{
    return view('lineasEstrategicas/alta');
}

public function set(Request $r)
{
    $v = Validator::make($r->all(),$this->_rules);
    if(!$v->fails()){
        $linea = new LineaEstrategica();
        $linea->crear($r);    
    }else{
        Log::info('La linea estrategica no paso la verificacion.'); 
    }
}

public function modificar(Request $r)
{
    $linea = LineaEstrategica::find($r->id);
    $linea->modificar($r);
}

public function get(Request $r,$id)    
{
    $linea = LineaEstrategica::find($id);
    return view('lineasEstrategicas/modificar',['linea' => $linea]);
}

    //Puedo pedir que en el request me manden una razon para la baja
public function borrar(Request $r,$id)
{
    LineaEstrategica::find($id)->delete();
}

}
