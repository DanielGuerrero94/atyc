<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pac\CategoriaPauta;
use Auth;
use Log;
use Validator;
use Datatables;

class CategoriasPautasController extends Controller
{

    private $rules = [
        'item'        => 'required|numeric',
        'nombre'      => 'required|string',
        'descripcion' => 'required|string'
    ];

    private $filters = [
        'item'        => 'numeric',
        'nombre'      => 'string',
        'descripcion' => 'string'
    ];

    private $botones = [
        'fa fa-pencil-square-o',
        'fa fa-trash-o'
    ];

    /**
    * View para abm.
    *
    * @return \Illuminate\Http\Response
    */
    public function get()
    {
        return view('categoriasPautas');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoriaPauta::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categoriasPautas/alta');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        logger('Quiere crear categoria pauta con: '.json_encode($request->all()));
        $v = Validator::make($request->all(), $this->rules);
        
        if ($v->fails()) {
            return response($v->errors(), 400);
        }
        $this->agregaRequest($request);

        $categoria = new CategoriaPauta();
        $categoria = $categoria->crear($request);
        return response($categoria->toArray(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoriaPauta = CategoriaPauta::findOrFail($id);
        $r = [
            'categoriaPauta' => $categoriaPauta
        ];
        return $r;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('categoriasPautas/modificar', $this->show($id));
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
        logger('Quiere actualizar categoria pauta {$id} con: '.json_encode($request->all()));
        try {
            $categoria = CategoriaPauta::findOrFail($id);
            $this->agregaRequest($request);
            return $categoria->crear($request);
        } catch (ModelNotFoundException $e) {
            return json_encode($e->message);
        }
    }

    private function agregaRequest(Request $r)
    {
        $r->request->add(['anio_vigencia' => date('Y')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return CategoriaPauta::findOrFail($id)->delete();
    }

    /**
     * Devuelve la informacion para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTabla(Request $r)
    {
        $query = CategoriaPauta::select('id_categoria_pauta', 'item', 'nombre', 'descripcion');


        return $this->toDatatable($r, $query);
    }

    /**
     * Devuelve en DataTable los resultados con sus correspondientes acciones.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Collection               $resultados
     * @return \Illuminate\Http\Response
     */
    public function toDatatable(Request $r, $resultados)
    {
        return Datatables::of($resultados)
        ->addColumn(
            'acciones',
            function ($ret) use ($r) {

                $accion = $r->has('botones')?$r->botones:null;

                $editarYEliminar = '<a href="'.url('categoriasPautas').'/'.$ret->id_categoria_pauta.'"><button data-id="'.
                $ret->id_categoria_pauta.'" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones[0].
                '" aria-hidden="true"></i></button></a>'.'<button data-id="'.$ret->id_categoria_pauta.
                '" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="'.$this->botones[1].
                '" aria-hidden="true"></i></button>';

                $agregar = '<button data-id="'.$ret->id_categoria_pauta.'" class="btn btn-info btn-xs agregar" '.
                'title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

                return $accion == 'agregar'?$agregar:$editarYEliminar;
            }
        )
        ->make(true);
    }
}
