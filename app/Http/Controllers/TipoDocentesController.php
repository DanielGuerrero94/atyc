<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoDocente;
use Datatables;

class TipoDocentesController extends ModelController
{
    /**
     * Rules for the validator
     *
     * @var array
     **/
    protected $rules = [
        'nombre' => 'required|string'
    ];

    protected $name = 'tipo_docentes';

    public function __construct(TipoDocente $model)
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
     * Devuelve la informacion para abm.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $request['botones']
     * @return \Illuminate\Http\Response
     */
    public function table(Request $request)
    {
        return $this->toDatatable($request, $this->model->all());
    }

    /**
     * Devuelve en DataTable los resultados con sus correspondientes acciones.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $request['botones']
     * @param  Collection               $resultados
     * @return \Illuminate\Http\Response
     */
    public function toDatatable(Request $r, $resultados)
    {
        return Datatables::of($resultados)
        ->addColumn(
            'acciones',
            function ($ret) use ($r) {

                $accion = $r->input('botones');

                $editar = '<a href="'.url('tipoDocentes').'/'.$ret->id_tipo_docente.'/edit'.'"><button data-id="'.
                $ret->id_tipo_docente.'" class="btn btn-info btn-xs editar" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>';

                $agregar = '<button data-id="'.$ret->id_tipo_docente.'" class="btn btn-info btn-xs agregar" '.
                'title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

                return $accion == 'agregar'?$agregar:$editar;
            }
        )
        ->make(true);
    }
}
