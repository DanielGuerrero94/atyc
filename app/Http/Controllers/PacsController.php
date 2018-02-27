<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pac\Pac;
use App\Models\Pac\Pauta;
use App\Models\Cursos\Curso;
use App\Models\Cursos\AreaTematica;
use App\Models\Cursos\LineaEstrategica;
use Datatables;
use Auth;

class PacsController extends ModelController
{

    /**
     * Rules for the validator
     *
     * @var array
     **/
    protected $rules = [];
    
    /**
     * Name of the Model
     *
     * @var string
     **/
    protected $name = 'pac';

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

    public function __construct(Pac $model)
    {
        $this->model = $model;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pacs/alta', $this->getSelectOptions());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add(['t1' => $request->has('t1')]);
        $request->request->add(['t2' => $request->has('t2')]);
        $request->request->add(['t3' => $request->has('t3')]);
        $request->request->add(['t4' => $request->has('t4')]);
        $request->request->add(['id_estado' => 1]);

        if (!$request->has('id_provincia')) {
            $id_provincia = Auth::user()->id_provincia;
            $request->request->add(['id_provincia' => $id_provincia]);
        }

        $acciones = $request->only(['repeticiones', 'nombre', 'id_linea_estrategica', 'id_provincia', 'id_estado', 'areasTematicas']);

        $relaciones = $request->only(['destinatarios', 'componentesCa', 'pautas']);

        $pac = $this->model
            ->create($request->all())
            ->generarAcciones($acciones)
            ->llenarRelaciones($relaciones);
                
        return $pac->id_pac;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array_merge($this->getSelectOptions(), $this->show($id));

        return view('pacs.modificacion', $data);
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
        $data = $this->model
            ->with(['pautas', 'componentesCa', 'destinatarios', 'acciones'])
            ->get()
            ->map(function ($model) {
                $model->areas_tematicas = $model->acciones->first()->areasTematicas;
                return $model;
            });

        logger(json_encode($data));

        return $this->toDatatable($request, $data);
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
        return Datatables::of($resultados)->make(true);
    }

    /**
     * Opciones para los selects del front end.
     *
     * @return array
     */
    public function getSelectOptions()
    {

        $tipologias = LineaEstrategica::orderBy('numero')->get();

        $tematicas = [];

        return compact('tipologias', 'tematicas');
    }
}
