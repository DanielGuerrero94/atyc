<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursos\AreaTematica;
use Datatables;

class AreasTematicasController extends AbmController
{
    /**
     * Rules for the validator
     *
     * @var array
     **/
    protected $rules = [
        'nombre' => 'required|string'
    ];

    protected $name = 'area';

    public function __construct(AreaTematica $model)
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
        return $this->model->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('areasTematicas/alta');
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
        return view('areasTematicas/modificar', $this->show($id));
    }

    /**
     * View para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodos()
    {
        return view('areasTematicas');
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
                return '<button data-id="'.$ret->id_area_tematica.'" class="btn btn-info btn-xs editar" '.
                'title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
            }
        )->make(true);
    }

    /**
     * Buscar por nombre y año de vigencia de las areas tematicas.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getTypeahead(Request $r)
    {
        $query = AreaTematica::select('id_area_tematica as id', 'nombre');

        $typed = $r->input('q');

        $nombre = explode(' ', $typed);

        logger()->warning(json_encode($nombre));

        foreach ($nombre as $key => $value) {
            $query = $query->orWhereRaw("nombre ~* '{$value}'");
        }

        $matchs = $query->get();

        return $this->typeaheadResponse($matchs);
    }
}
