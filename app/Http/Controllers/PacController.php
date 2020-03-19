<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pac\Pac;
use App\Models\Pac\Componente;
use App\Models\Pac\Destinatario;
use App\Models\Pac\Pauta;
use App\Models\Pac\Responsable;
use App\Models\Pac\Tematica;
use App\Models\Pac\TipoAccion;
use App\Provincia;
use App\Periodo;
use Cache;
use DB;
use Auth;
use Log;
use Validator;
use Datatables;
use Excel;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class PacController extends AbmController
{
        /**
     * Rules for validate the request
     *
     * @var array
     **/
    // private $rules = [
    //     'nombre' => 'required|string',
    //     'duracion' => 'required|numeric',
    //     'fecha' => 'required',
    //     'id_tematica' => 'required|numeric',
    //     'id_accion' => 'required|numeric',
    //     'id_provinci<a' => 'required|numeric'
    // ];

    /**
     * Filter rules
     *
     * @var array
     **/
    private $filters = [
        'id_accion' => 'numeric',
        'nombre' => 'string',
        'duracion' => 'numeric',
        'id_provincia' => 'numeric',
        'id_tematica' => 'numeric',
        'id_destinatarios' => 'numeric',
        'id_responsable' => 'numeric',
        'id_pautas' => 'numeric',
        'id_componente' => 'numeric',
        'id_periodo' => 'numeric',
        'desde' => 'string',
        'hasta' => 'string'
    ];

    /**
     * Icono de botones
     *
     * @var array
     **/
    private $botones = [
        'editar' => 'fa fa-pencil-square-o',
        'eliminar' => 'fa fa-trash-o',
        'buscar' => 'fa <',
        'agregar' => 'fa fa-plus-circle'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return json_encode(Pac::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	return response()->json(['success' => false]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    try {
	        $pac = Pac::with('destinatarios', 'pautas', 'responsables', 'componentes', 'tipoAccion', 'tematicas')
		     ->where('id_pac', $id)->firstOrFail();
		return response()->json(['success' => true, 'data' => $pac->toJson()]);
	    } catch (ModelNotFoundException $e) {
		return response()->json(['success' => false, 'error' => $e->getMessage()]);
	    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
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
    public function get()
    {
        return view('pacs', $this->getSelectOptions());
    }

    /**
     * Opciones para los selects del front end.
     *
     * @return array
     */

public function filtrar(Request $request)
    {
        $filtros = collect($r->get('filtros'))
        ->mapWithKeys(function ($item) {
            return $item;
        });

        $query = Pac::select(
            'id_pac',
            'nombre',
            'id_tipo_accion',
            'edicion',
            'id_provincia',
            'ficha_tecnica'
        )
        ->with([
            'tipoAccion',
            'provincia'
        ])
        //->withCount('alumnos')
        ->segunProvincia();

        foreach ($filtros as $key => $value) {
            if ($key == 'nombre') {
                $query = $query->where('pac.pacs'.$key, 'ilike', "%{$value}%");
            // } elseif ($key == 'desde') {
            //     $query = $query->where('pac.pacs.fecha', '>=', $value);
            // } elseif ($key == 'hasta') {
            //     $query = $query->where('cursos.cursos.fecha', '<=', $value);
            // } elseif ($key == 'id_periodo') {
            //     $periodo = Periodo::find($value);
            //     $query = $query->where('cursos.cursos.fecha', '>=', $periodo->desde);
            //     $query = $query->where('cursos.cursos.fecha', '<=', $periodo->hasta);
            } else {
                $query = $query->where('pac.pacs.'.$key, $value);
            }
        }

        //logger()->warning(json_encode($query->first()));

        return $this->toDatatable($request, $query);
        return Datatables::of($query);
    }
    public function getSelectOptions()
    {
        $pautas = Cache::remember('pautas', 5, function () {
            return Pauta::all();
        });

        $componentes = Cache::remember('componentes_cai', 5, function () {
            return Componente::all();
        });

        $destinatarios = Cache::remember('destinatarios', 5, function () {
            return Destinatario::all();
        });

        $responsables = Cache::remember('responsables', 5, function () {
            return Responsable::all();
        });

        $tematicas = Cache::remember('tematicas', 5, function () {
            return Tematica::all();
        });

        $tipoAcciones = Cache::remember('tipo_accion', 5, function () {
            return TipoAccion::all();
        });

        $provincias = Cache::remember('provincias', 5, function () {
            return Provincia::orderBy('nombre')->get();
        });

        $periodos = Cache::remember('periodos', 5, function () {
            return Periodo::all();
        });

        return [
            'pautas' => $pautas,
            'componentes' => $componentes,
            'destinatarios' => $destinatarios,
            'responsables' => $responsables,
            'tematicas' => $tematicas,
            'tipoAcciones' => $tipoAcciones,
            'provincias' => $provincias,
            'periodos' => $periodos
        ];
    }
}
