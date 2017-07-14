<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursos\AreaTematica;
use Datatables;

class AreasTematicasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(AreaTematica::all());
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $area = new AreaTematica();
            return $area->create($request->all());
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
        $area = AreaTematica::find($id);
        return array('area' => $area);
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $area = AreaTematica::find($id);
        $area->modificar($request);
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
        $area = AreaTematica::find($id);
        $area->delete();
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
        $returns = AreaTematica::all();
        return Datatables::of($returns)
        ->addColumn(
            'acciones',
            function ($ret) {
                return '<button data-id="'.$ret->id_area_tematica.'" class="btn btn-info btn-xs editar" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'.'<button data-id="'.$ret->id_area_tematica.'" class="btn btn-danger btn-xs eliminar" title="Eliminar" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Some content"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
            }
        )
        ->make(true);
    }
}
