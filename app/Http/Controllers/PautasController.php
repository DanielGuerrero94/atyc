<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pauta;
use App\PautaAction;


class PautasController extends Controller
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
        $pautasactions = PautaAction::all();
        return view('home', [ 'layout' => 'layouts.pauta' ])->with(['pautasactions' => $pautasactions]);
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
            'item'        => 'required',
            'nombre'        => 'required',
            'descripcion'   => 'required'
        ]);
//dd($request->action);
        $pauta = new Pauta();
        $pauta->item            = $request->item;
        $pauta->nombre          = $request->nombre;
        $pauta->descripcion     = $request->descripcion;
        $pauta->id_pauta_action = $request->action;

        if($pauta->save()){
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
