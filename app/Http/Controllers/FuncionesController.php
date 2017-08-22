<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Funcion;
use Datatables;

//Exceptions
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class FuncionesController extends Controller
{
    private $botones = ['fa fa-pencil-square-o','fa fa-trash-o'];

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('funciones');
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('funciones.alta');
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        try {
            return Periodo::create($request->only(['nombre']));            
        } catch (Illuminate\Database\QueryException $e) {
            return json_encode($e->message);
        }
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        return array('funciones' => Funcion::findOrFail($id));
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        try {
            return view('funciones.modificacion',$this->show($id));
        }  catch (ModelNotFoundException $e) {
            return json_encode($e->getMessage());
        }
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
        try {
            return Funcion::findOrFail($id)
            ->update($request->all());
        }  catch (ModelNotFoundException $e) {
            return json_encode($e->getMessage());
        }
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        try {
            return Funcion::findOrFail($id)
            ->delete();
        }  catch (ModelNotFoundException $e) {
            return json_encode($e->getMessage());
        }
    }

    /**
     * Devuelve la informacion para abm.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $request['botones']
     * @return \Illuminate\Http\Response
     */
    public function table(Request $r)
    {
        return $this->toDatatable($r, Periodo::all());
    }

    /**
     * Devuelve en DataTable los resultados con sus correspondientes acciones.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $request['botones']
     * @param  Collection               $resultados
     * @return \Illuminate\Http\Response
     */
    public function toDatatable(Request $r, $resultados)
    {
        return Datatables::of($resultados)
        ->addColumn(
            'acciones',
            function ($ret) use ($r) {

                $accion = $r->input('botones');

                $editar = '<a href="'.url('funciones').'/'.$ret->id_funcion.'/edit'.'"><button data-id="'.$ret->id_funcion.'" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones[0].'" aria-hidden="true"></i></button></a>';

                $agregar = '<button data-id="'.$ret->id_funcion.'" class="btn btn-info btn-xs agregar" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

                return $accion == 'agregar'?$agregar:$editar;
            }
            )
        ->make(true);
    }
}
