<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursos\LineaEstrategica;
use Datatables;

class LineasEstrategicasController extends ModelController
{
    /**
     * Rules for the validator
     *
     * @var array
     **/
    protected $rules = [
        'nombre' => 'required|string'
    ];

    protected $name = 'linea';

    public function __construct(LineaEstrategica $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->model->withTrashed()->get();
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
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('lineasEstrategicas.modificar', $this->show($id));
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
        return Datatables::of($this->index())
        ->addColumn(
            'acciones',
            function ($ret) {
                return '<button data-id="'.$ret->id_linea_estrategica.'" class="btn btn-info btn-xs editar" '.
                'title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                /*
                '<button data-id="'.$ret->id_linea_estrategica.'" class="btn btn-danger btn-xs eliminar" '.
                'title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'
                */
            }
        )
        ->make(true);
    }
}
