<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Funcion;
use Datatables;
use Log;

//Exceptions
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class FuncionesController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        return view('funciones');
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create(Request $request)
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
        return Funcion::create($request->only(['nombre']));
    }
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $funcion = Funcion::findOrFail($id);
        return compact('funcion');
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        return view('funciones.modificacion', $this->show($id));
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
        Funcion::findOrFail($id)->update($request->all());
        return response('Updated', 200);
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //No es conveniente por ahora que puedan borrar
        //Funcion::findOrFail($id)->delete();
        // return response('Deleted', 200);            
        return response('DatabaseError', 403);
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
        return $this->toDatatable($r, Funcion::all());
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
        return Datatables::of($resultados)->make(true);
    }
    
    /**
     * Si la request es ajax devulve el contenido sin extender el layout
     */
    public function setView($path, $data = [], Request $request)
    {
        $path = $request->isXmlHttpRequest()?"{$path}.ajax":$path;
        return view($path, $data);
    }
}
