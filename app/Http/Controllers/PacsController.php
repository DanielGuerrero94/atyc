<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pac\Pac;

class PacsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pacs/alta', $this->getSelectOptions());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pac = Pac::create($request->all());


        if ($request->has('destinatarios')) {
            $pac->destinatarios()->attach(explode(',', $request->get('destinatarios')));
        }

        if ($request->has('accion')) {
            $accion = $request->only('nombre', 'id_linea_estrategica', 'id_area_tematica');
            eval(\Psy\sh());
            $pac->acciones()->create($accion);
        }

        $id_pac = $pac->id_pac;
        return $id_pac;
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
        return view('pacs.modificacion', array_merge($this->getSelectOptions(), $this->show($id)));
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
