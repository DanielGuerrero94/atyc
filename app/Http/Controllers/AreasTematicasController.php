<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursos\AreaTematica;
use Datatables;
use Carbon\Carbon;

class AreasTematicasController extends ModelController
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
        return $this->model->orderBy('deleted_at', 'desc')->orderBy('nombre')->withTrashed()->get();
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
                $buttons = '<a data-id="'.$ret->id_area_tematica.'" class="btn btn-circle editar" '.
                'title="Editar" style="margin-right: 1rem;"><i class="fa fa-pencil" aria-hidden="true" style="color: dodgerblue;"></i></a>';

                if($ret->deleted_at)
                    $buttons .= '<a data-id="'.$ret->id_area_tematica.'" class="btn btn-circle darAlta" '.
                    'title="Dar de alta" style="margin-right: 1rem;"><i class="fa fa-plus" aria-hidden="true" style="color: forestgreen;"></i></a>';
                else
                    $buttons .= '<a data-id="'.$ret->id_area_tematica.'" class="btn btn-circle darBaja" '.
                    'title="Dar de baja" style="margin-right: 1rem;"><i class="fa fa-minus" aria-hidden="true" style="color: firebrick;"></i></a>';
                
                if($this->seCreoLaMismaSemana($ret))
                    $buttons .= '<a data-id="'.$ret->id_area_tematica.'" class="btn btn-circle eliminar" '.
                'title="Eliminar" style="margin-right: 1rem;"><i class="fa fa-trash" aria-hidden="true" style="color: dimgray;"></i></a>';

                return $buttons;
            }
        )
        ->make(true);
    }

    public function seCreoLaMismaSemana($ret)
    {
        $validTime = Carbon::now()->subDays(7);
        return $validTime <= $ret->created_at;
    }
    
    public function hardDestroy($id)
    {
        logger("Voy a destruir el registro del area tematica: ".$id);
        return response()->json($this->model->withTrashed()->findOrFail($id)->forceDelete());
    }

    public function alta($id)
    {
        logger("Voy a dar de alta el area tematica ".$id);
        return response()->json($this->model->withTrashed()->findOrFail($id)->restore());
    }
}
