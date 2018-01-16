<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pac\Pac;
use Datatables;

class PacsController extends Controller
{

    /**
     * Icono de botones
     *
     * @var array
     **/
    private $botones = [
        'editar' => 'fa fa-pencil-square-o',
        'eliminar' => 'fa fa-trash-o',
        'buscar' => 'fa fa-search',
        'agregar' => 'fa fa-plus-circle'
    ];    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pacs/alta');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pac = new Pac();
        return $pac->create($request->all());
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pacs.modificacion', array_merge($this->getSelectOptions(), $this->show($id)));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * View para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodos()
    {
        return view('pacs');
    }

    /**
     * Devuelve la informacion para abm.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTabla(Request $request)
    {
        $query = Pac::all();

        return $this->toDatatable($request, $query);
    }

    /**
     * Devuelve en DataTable los resultados con sus correspondientes acciones.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Support\Collection  $resultados
     * @return \Illuminate\Http\Response
     */
    public function toDatatable(Request $r, $resultados)
    {
        return Datatables::of($resultados)
        ->addColumn('acciones', function ($ret) use ($r) {

            $accion = $r->has('botones')?$r->botones:null;

            $editarYEliminar = '<a href="'.url('cursos').'/'.$ret->id_pac.'"><button data-id="'.$ret->id_pac.
            '" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones['editar'].
            '" aria-hidden="true"></i></button></a>'.'<button data-id="'.$ret->id_pac.
            '" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="'.$this->botones['eliminar'].
            '" aria-hidden="true"></i></button>';
            
            $agregar = '<button data-id="'.$ret->id_pac.'" class="btn btn-info btn-xs agregar" '.
            'title="Agregar"><i class="'.$this->botones['agregar'].'" aria-hidden="true"></i></button>';

            return $accion == 'agregar'?$agregar:$editarYEliminar;
        })
        ->make(true);
    }    
}
 