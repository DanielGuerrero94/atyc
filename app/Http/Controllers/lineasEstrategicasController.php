<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LineaEstrategica;
use Datatables;

class lineasEstrategicasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(LineaEstrategica::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lineasEstrategicas/alta');
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $linea = new LineaEstrategica();
        $linea->crear($request);    
    }    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $linea = LineaEstrategica::find($id);
        return array('linea' => $linea);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('lineasEstrategicas/modificar',$this->show($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $linea = LineaEstrategica::find($id);
    $linea->modificar($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LineaEstrategica::find($id)->delete();
    }

    /**
     * View para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodos()
    {
      return view('lineasEstrategicas');    	
  }

  /**
     * Devuelve la informacion para abm.
     *
     * @return \Illuminate\Http\Response
     */
  public function getTabla()
  {
    $returns = LineaEstrategica::table();       
    return Datatables::of($returns)
    ->addColumn('acciones' , function($ret){
        return '<button data-id="'.$ret->id_linea_estrategica.'" class="btn btn-info btn-xs editar" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'.'<button data-id="'.$ret->id_linea_estrategica.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
    })            
    ->make(true); 
}
}
