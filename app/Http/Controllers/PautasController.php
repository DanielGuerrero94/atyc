<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Pac\CategoriaPauta;
use App\Models\Pac\Pauta;
use App\Provincia;
use Cache;
use DB;
use Auth;
use Log;
use Validator;
use Datatables;
use Excel;
use App\PDF as Pdf;

class PautasController extends AbmController
{

    private $rules = [
        'item' => 'required|string',
        'nombre' => 'required|string',
        'descripcion' => 'required|string',
        'id_categoria_pauta' => 'required|numeric'
    ];

    private $filters = [
        'item' => 'string',
        'nombre' => 'string',
        'descripcion' => 'string',
        'id_categoria_pauta' => 'numeric'
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
        return view('pautas', $this->getSelectOptions());
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return Pauta::all();
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('pautas/alta', $this->getSelectOptions());
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        logger('Quiere crear pauta con: '.json_encode($request->all()));
        $v = Validator::make($request->all(), $this->rules);
        
        if ($v->fails()) return response($v->errors(), 400);

        $pauta = new Pauta();
        $pauta = $pauta->crear($request);
        return response($pauta->toArray(), 200);
    }

    /**
        * Display the specified resource.
        *
        * @param  int $id
        * @return \Illuminate\Http\Response
        */
    public function show($id)
    {
        $pauta = Pauta::findOrFail($id);
        $r = [
            'pauta' => $pauta
        ];
        return array_merge($r, $this->getSelectOptions());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pautas/modificar', $this->show($id));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  int                      $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        logger('Quiere actualizar pauta {$id} con: '.json_encode($request->all()));
        try {
            $pauta = Pauta::findOrFail($id);
            return $pauta->modificar($request);
        } catch (ModelNotFoundException $e) {
            return json_encode($e->message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Pauta::findOrFail($id)->delete();
    }

    /**
     * Devuelve la informacion para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTabla(Request $r)
    {
        $query = Pauta::select('id_pauta', 'item', 'nombre', 'descripcion', 'id_categoria_pauta');

        return $this->toDatatable($r, $query);
    }

    private function queryLogica(Request $r, $filtros)
    {
        $query = Pauta::select(
            'pac.pautas.id_pauta',
            'pac.pautas.nombre',
            'pac.pautas.descripcion',
            'pac.categorias_pautas.nombre as categoria',
            'pac.pautas.item',
            'pac.pautas.id_categoria_pauta'
        )
        ->with('categoriaPauta');

        return $query;
    }

    public function getFiltrado(Request $r)
    {
        $filtros = collect($r->get('filtros'))
        ->mapWithKeys(function ($item) {
            return [$item['name'] => $item['value']] ;
        });

        $v = Validator::make($filtros->all(), $this->filters);

        if ($v->fails()) {
            return $v->errors();
        }
        
        $query = $this->queryLogica($r, $filtros);
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

                $editarYEliminar = '<a href="'.url('pautas').'/'.$ret->id_pauta.'"><button data-id="'.
                $ret->id_pauta.'" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones[0].
                '" aria-hidden="true"></i></button></a>'.'<button data-id="'.$ret->id_pauta.
                '" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="'.$this->botones[1].
                '" aria-hidden="true"></i></button>';

                $agregar = '<button data-id="'.$ret->id_pauta.'" class="btn btn-info btn-xs agregar" '.
                'title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

                return $accion == 'agregar'?$agregar:$editarYEliminar;
            }
        )
        ->make(true);
    }

    /**
     * Opciones para los selects del front end.
     *
     * @return array
     */
    public function getSelectOptions()
    {
        $categoriaPautas = CategoriaPauta::all();
        $provincias = Provincia::all();

        return [
            'categoriaPauta' => $categoriaPautas,
            'provincias'     => $provincias,
        ];
    }

    /**
     * Buscar por numero de documento, nombres y apellidos de los docentes.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getTypeahead(Request $r)
    {
        $query = Pauta::select('id_pauta as id', 'nombre', 'descripcion', 'item');

        $typed = $r->input('q');
        if (is_numeric($typed)) {
            $query = $query->whereRaw("CAST(item as character varying) ~ '^{$typed}'");
        } else {
            $nombre = explode(' ', $typed);

            foreach ($nombre as $key => $value) {
                $query = $query->orWhereRaw("nombre ~* '{$value}'")
                ->orWhereRaw("descripcion ~* '{$value}'");
            }
        }

        $matchs = $query
        ->get();

        return $this->typeaheadResponse($matchs);
    }

}
