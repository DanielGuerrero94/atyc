<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pac\ComponenteCa;
use Datatables;

class ComponentesCaController extends AbmController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ComponenteCa::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('componentesCa/alta');
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
        $compo = new ComponenteCa();
        return $compo->create($request->all());
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
        $compo = ComponenteCa::find($id);
        return array('compo' => $compo);
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
        return view('componentesCa/modificar', $this->show($id));
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
        $compo = ComponenteCa::find($id);
        $compo->modificar($request);
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
        $compo = ComponenteCa::find($id);
        $compo->delete();
    }

    /**
     * View para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodos()
    {
        return view('componentesCa');
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
                return '<button data-id="'.$ret->id_componente_ca.'" class="btn btn-info btn-xs editar" '.
                'title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
            }
        )->make(true);
    }

    /**
     * Buscar por nombre y año de vigencia de los componentes Ca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getTypeahead(Request $r)
    {
        $query = ComponenteCa::select('id_componente_ca as id', 'nombre');

        $typed = $r->input('q');

        $nombre = explode(' ', $typed);

        foreach ($nombre as $key => $value) {
            $query = $query->orWhereRaw("nombre ~* '{$value}'");
        }

        //$query = $query->where('anio_vigencia', date());

        $matchs = $query->get();

        return $this->typeaheadResponse($matchs);
    }
}
