<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PautaAction;

class PautasActionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home', [ 'layout' => 'layouts.pautaAccion' ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'item'          => 'integer',
            'nombre'        => 'required',
            'descripcion'   => 'required',
            'aniovigencia'  => 'integer'
        ]);
//dd($request);
        $pautaAction = new PautaAction();
        $pautaAction->item          = $request->item;
        $pautaAction->nombre        = $request->nombre;
        $pautaAction->descripcion   = $request->descripcion;
        $pautaAction->anio_vigencia = $request->anioVigencia;

        if($pautaAction->save()){
            return back()->with('msj', 'Datos guardados');
        }else{
            return back()->with('errormsj', 'Error al guardar los datos');
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
        //
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
}
