<?php

namespace App\Http\Controllers;

use App\Models\Cursos\Modalidad;
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
        return $this->model
            ->with('modalidades')
            ->orderBy('deleted_at', 'desc')
            ->orderBy('numero')
            ->withTrashed()
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lineaEstrategica = parent::store($request);

        $lineaEstrategica->modalidades()->attach(explode(",", $request->get('ids_modalidad')));

        return response()->json(['linea' => $lineaEstrategica], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modalidades = Modalidad::get();

        return view('lineasEstrategicas/alta', compact('modalidades'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return [$this->name => $this->model->with('modalidades')->withTrashed()->findOrFail($id)];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modalidades = Modalidad::get();

        return view(
            'lineasEstrategicas.modificar',
            array_merge(compact('modalidades'), $this->show($id))
        );
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
        $response = parent::update($request, $id);

        $lineaEstrategica = $this->model->withTrashed()->findOrFail($id);

        $lineaEstrategica->modalidades()->sync(explode(",", $request->get('ids_modalidad')));

        return $response;
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
