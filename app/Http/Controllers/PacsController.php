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

        $repeticiones = $request->repeticiones;

        $request->request->add(['t1' => $request->has('t1')]);        
        $request->request->add(['t2' => $request->has('t2')]);
        $request->request->add(['t3' => $request->has('t3')]);
        $request->request->add(['t4' => $request->has('t4')]);
     

        $id_provincia = Auth::user()->id_provincia;
        $estado = 1;
        $request->request->add(['id_provincia' => $id_provincia]);

        for ($i=0; $i < $repeticiones; $i++) { 
            $curso = new Curso();
            
            $parametros = array_merge(['id_estado' => $estado ],$request->only(['nombre', 'id_linea_estrategica', 'id_provincia']));

            if ($request->has('areasTematicas')) {
                $areasTematicas = explode(',', $request->get('areasTematicas'));
                $curso->areasTematicas()->attach($areasTematicas);
            }            
            $curso->create($parametros);
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
        $query = Pac::with(['pautas','componentesCa','destinatarios'])->get();

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

            $editarYEliminar = '<a href="'.url('pacs').'/'.$ret->id_pac.'"><button data-id="'.$ret->id_pac.
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

        $lineas = LineaEstrategica::all();

        return [
            'lineas_estrategicas' => $lineas
        ];
    }             
}
