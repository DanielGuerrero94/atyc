<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Periodo;
use Datatables;

class PeriodosController extends Controller
{
    private $botones = ['fa fa-pencil-square-o','fa fa-trash-o'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('periodos');
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('periodos.alta');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            return Periodo::create($request->only(['nombre','desde','hasta']));            
        } catch (Illuminate\Database\QueryException $e) {
            return json_encode($e->message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return array(
                'periodo' => Periodo::findOrFail($id)
                );            
        } catch (ModelNotFoundException $e) {
            return json_encode($e->message);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('periodos.modificar',$this->show($id));
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
        try {
            $p = Periodo::findOrFail($id)
            ->update($request->all());
        } catch (ModelNotFoundException $e) {
            return json_encode($e->message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return json_encode('No se puede borrar');
    }

    /**
     * Devuelve la informacion para abm.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $request['botones']
     * @return \Illuminate\Http\Response
     */
    public function table(Request $r)
    {
        return $this->toDatatable($r, Periodo::all());
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

                $editar = '<a href="'.url('periodos').'/'.$ret->id_periodo.'/edit'.'"><button data-id="'.$ret->id_periodo.'" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones[0].'" aria-hidden="true"></i></button></a>';

                $agregar = '<button data-id="'.$ret->id_periodo.'" class="btn btn-info btn-xs agregar" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

                return $accion == 'agregar'?$agregar:$editar;
            }
            )
        ->make(true);
    }
}
