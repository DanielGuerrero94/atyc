<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pac\Estado;
use Datatables;

class EstadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Estado::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('estados/alta');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $esta = new Estado();
        return $esta->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $esta = Estado::find($id);
        return array('esta' => $esta);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('estados/modificar', $this->show($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $esta = Estado::find($id);
        $esta->modificar($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $esta = Estado::find($id);
        $esta->delete();
    }

    /**
     * View para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodos()
    {
        return view('estados');
    }
    
    /**
     * Devuelve la informacion para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTabla()
    {
        return Datatables::of($this->index())
        ->addColumn(
            'acciones',
            function ($ret) {
                return '<button data-id="'.$ret->id_estado.'" class="btn btn-info btn-xs editar" '.
                'title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                /*
                '<button data-id="'.$ret->id_estado.'" class="btn btn-danger btn-xs eliminar" '.
                'title="Eliminar" data-toggle="popover" data-trigger="hover" data-placement="right" '.
                'data-content="Some content"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'
                */
            }
        )
        ->make(true);
    }
}
