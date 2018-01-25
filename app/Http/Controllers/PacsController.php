<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pac\Pac;
use App\Models\Pac\Pauta;
use App\Models\Cursos\Curso;
use App\Models\Cursos\AreaTematica;
use App\Models\Cursos\LineaEstrategica;
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
/**********/
        $repeticiones = $request->repeticiones;

        if ($request->has('t1')) {
            $request->request->add(['t1' => 1]);
        }else{        
            $request->request->add(['t1' => 0]);
        }
        
        if ($request->has('t2')) {
            $request->request->add(['t2' => 1]);
        }else{        
            $request->request->add(['t2' => 0]);
        }

        if ($request->has('t3')) {
            $request->request->add(['t3' => 1]);
        }else{        
            $request->request->add(['t3' => 0]);
        }

        if ($request->has('t4')) {
            $request->request->add(['t4' => 1]);
        }else{        
            $request->request->add(['t4' => 0]);
        }

        if ($request->has('consul_peatyc')) {
            $request->request->add(['consul_peatyc' => 1]);
        }else{        
            $request->request->add(['consul_peatyc' => 0]);
        }        

        for ($i=0; $i < $repeticiones; $i++) { 
            $curso = new Curso();
            $curso->create($request->only(['nombre', 'id_area_tematica', 'id_linea_estrategica']));
        }

        
        $pac = Pac::create($request->all());

        if ($request->has('destinatarios')) {
            $destinatarios = explode(',', $request->get('destinatarios'));
            $pac->destinatarios()->attach($destinatarios);
        }

        if ($request->has('componentesCa')) {
            $componentes = explode(',', $request->get('componentesCa'));
            $pac->componentesCa()->attach($componentes);
        }

        if ($request->has('pautas')) {
            $pautas = explode(',', $request->get('pautas'));
            $pac->pautas()->attach($pautas);
        }
/************/

        return $pac->id;
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

    /**
     * Opciones para los selects del front end.
     *
     * @return array
     */
    private function getSelectOptions()
    {
        $areas = AreaTematica::all();

        $lineas = LineaEstrategica::all();

        return [
            'areas_tematicas' => $areas,
            'lineas_estrategicas' => $lineas
        ];
    }             
}
