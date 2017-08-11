<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoDocente;

//Exceptions
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class TipoDocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tipoDocentes');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tipoDocentes.alta');
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
            return TipoDocente::create($request->only('nombre'));
        } catch (QueryException $e) {
            return json_encode($e->getMessage());
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
        try {
            return TipoDocente::findOrFail($id)->toJson();
        } catch (ModelNotFoundException $e) {
            return json_encode($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('tipoDocentes.modificacion');        
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
            return TipoDocente::findOrFail($id)
            ->update($request->all());
        } catch (ModelNotFoundException $e) {
            return json_encode($e->getMessage());
        } catch (QueryException $e) {
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
            return TipoDocente::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return json_encode($e->getMessage());
        } catch (QueryException $e) {
            return json_encode($e->getMessage());
        }
    }
}
