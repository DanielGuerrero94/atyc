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
        return $this->model->orderBy('deleted_at', 'desc')->orderBy('numero')->withTrashed()->get();
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
        return Datatables::of($this->index())->make(true);
    }
}
