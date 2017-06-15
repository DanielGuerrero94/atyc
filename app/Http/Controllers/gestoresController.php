<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use Log;
use Validator;
use Datatables;

class gestoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gestores.gestores');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
            $gestor = User::findOrFail($id);    
        } catch (ModelNotFoundException $e) {
            $gestor = null;
        }
            return json_encode($gestor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getTabla()
    {        
        $query = User::select('id','name as nombre','email');
        return Datatables::of($query)
        ->addColumn('acciones' , function($ret){
            return '<button data-id="'.$ret->id.'" class="btn btn-info btn-xs editar" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'.'<button data-id="'.$ret->id.'" class="btn btn-danger btn-xs eliminar" title="Eliminar" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Some content"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';

        })            
        ->make(true); 
    }
}
