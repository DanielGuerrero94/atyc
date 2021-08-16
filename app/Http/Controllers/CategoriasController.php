<?php

namespace App\Http\Controllers;

use App\Models\Pac\Categoria;
use Datatables;
use Illuminate\Http\Request;

class CategoriasController extends ModelController
{
    /**
     * Rules for the validator
     *
     * @var array
     **/
    protected $rules = [
        'anios'      => 'required',
        'numero'     => 'required|numeric',
        'nombre'     => 'required|string',
        'provincial' => 'required',
    ];

    protected $name = 'categoria';

    public function __construct(Categoria $model)
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
        return $this->model->with('anios')
            ->orderBy('deleted_at', 'desc')
            ->orderBy('numero')
            ->withTrashed()
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias/alta');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error = $this->validate($request, $this->rules);

        if ($error) {
            return response($error, 400);
        }

        $categoria = $this->model->create($request->all());

        $anios = array_map(function ($anio) {
            return ['anio' => $anio];
        }, explode(',', $request->get('anios')));

        $categoria->anios()->createMany($anios);

        return response()->json(['data' => $categoria]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('categorias/modificar', $this->show($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $error = $this->validate($request, $this->rules);

        if ($error) {
            return response($error, 400);
        }

        $categoria = $this->model->withTrashed()->findOrFail($id);

        $categoria->update($request->all());

        $anios = array_map(function ($anio) {
            return ['anio' => $anio];
        }, explode(',', $request->get('anios')));

        $categoria->anios()->delete();
        $categoria->anios()->createMany($anios);

        return response()->json($categoria);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return [$this->name => $this->model->with('anios')->withTrashed()->findOrFail($id)];
    }

    /**
     * View para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodos()
    {
        return view('categorias');
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
                    $buttons = '<a data-id="' . $ret->id_categoria . '" class="btn btn-circle editar" ' .
                        'title="Editar" style="margin-right: 1rem;"><i class="fa fa-pencil" aria-hidden="true" style="color: dodgerblue;"></i></a>';

                    if ($ret->deleted_at) {
                        $buttons .= '<a data-id="' . $ret->id_categoria . '" class="btn btn-circle darAlta" ' .
                            'title="Dar de alta" style="margin-right: 1rem;"><i class="fa fa-plus" aria-hidden="true" style="color: forestgreen;"></i></a>';
                    } else {
                        $buttons .= '<a data-id="' . $ret->id_categoria . '" class="btn btn-circle darBaja" ' .
                            'title="Dar de baja" style="margin-right: 1rem;"><i class="fa fa-minus" aria-hidden="true" style="color: firebrick;"></i></a>';
                    }

                    if ($this->seCreoLaMismaSemana($ret)) {
                        $buttons .= '<a data-id="' . $ret->id_categoria . '" class="btn btn-circle eliminar" ' .
                            'title="Eliminar" style="margin-right: 1rem;"><i class="fa fa-trash" aria-hidden="true" style="color: dimgray;"></i></a>';
                    }

                    return $buttons;
                }
            )
            ->make(true);
    }

    public function hardDestroy($id)
    {
        $categoria = $this->model->withTrashed()->findOrFail($id);

        $categoria->anios()->delete();

        $categoria->forceDelete();

        return response()->json($categoria);
    }
}
