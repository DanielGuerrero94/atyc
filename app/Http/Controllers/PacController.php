<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pac\Pac;
use App\Models\Pac\Componente;
use App\Models\Pac\Destinatario;
use App\Models\Pac\Pauta;
use App\Models\Pac\Categoria;
use App\Models\Pac\Responsable;
// use App\Models\Pac\Tematica;
// use App\Models\Pac\TipoAccion;
use App\Models\Pac\FichaTecnica;
use App\Models\Cursos\Curso;
use App\Models\Cursos\AreaTematica;
use App\Models\Cursos\LineaEstrategica;
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
    private $rules = [
        'nombre' => 'required|string',
        'id_accion' => 'required|numeric',
        'ediciones' => 'required|numeric',
        'duracion' => 'required|numeric',
        'id_provincia' => 'required|numeric',
        'ids_tematicas' => 'required',
        'ids_destinatarios' => 'required',
        'ids_responsables' => 'required',
        'ids_pautas' => 'required',
        'ids_componentes' => 'required'
    ];

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
        return json_encode(Pac::all());
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

    public function crearCursos($pac, $request)
    {
        for($i = 0; $i < $request->ediciones; $i++) {
            $edicion = Curso::where([
                ['nombre', '=', $request->nombre],
                ['id_provincia', '=', $request->id_provincia],
            ])
            ->count() + 1;

            $fecha_inicio_actual = 'fecha_inicio_'.($i+1);
            $fecha_final_actual = "fecha_final_".($i+1);

            $data = $request->all(); //only();
            $estado = 1;
            $data = array_merge($data, [
                'id_pac' => $pac->id_pac,
                'id_estado' => $estado,
                'edicion' => $edicion,
                'id_area_tematica' => $request->id_tematica,
                'id_linea_estrategica' => $request->id_accion,
                'fecha_plan_inicial' => $request->$fecha_inicio_actual,
                'fecha_plan_final' => $request->$fecha_final_actual
                ]);

            $curso = Curso::create($data);
            logger('Creo el curso: '.json_encode($curso));

            $tematicas = explode(',', $request->get('ids_tematicas'));
            $curso->areasTematicas()->attach($tematicas);
        }
    }

    public function attachPivotTables($pac, $request)
    {
        $tematicas = explode(',', $request->get('ids_tematicas'));
        $pac->tematicas()->attach($tematicas);

        $destinatarios = explode(',', $request->get('ids_destinatarios'));
        $pac->destinatarios()->attach($destinatarios);

        $responsables = explode(',', $request->get('ids_responsables'));
        $pac->responsables()->attach($responsables);

        $pautas = explode(',', $request->get('ids_pautas'));
        $pac->pautas()->attach($pautas);

        $componentes = explode(',', $request->get('ids_componentes'));
        $pac->componentes()->attach($componentes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        logger('Quiere crear PAC con: '.json_encode($data));
        $v = Validator::make($data, $this->rules);

        if ($v->fails()) {
            return $v->errors();
        }

        $pac = Pac::create($data);
        logger('Crea pac: '.$pac);

        $this->attachPivotTables($pac, $request);
        $this->crearCursos($pac, $request);

        $id_ficha_tecnica = $request->get('id_ficha_tecnica');
        logger('id_ficha_tecnica: '.$id_ficha_tecnica);

        if($id_ficha_tecnica)
            $this->cambiarEstadoCursos($pac->id_pac, 2);
        
        return $pac;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_pac)
    {
        return $this->getPacWithTrashed($id_pac);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_pac)
    {
        return view('pacs.modificacion', array_merge($this->show($id_pac), $this->getEditOptions()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_pac)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_pac)
    {
        logger()->warning("Voy a Borrar:");

        $pac = Pac::findOrFail($id_pac);
        logger()->warning("PAC:\n".$pac);
        $pac->delete();

        if($pac->id_ficha_tecnica)
        {
            $ficha_tecnica = FichaTecnica::findOrFail($pac->id_ficha_tecnica);
            logger()->warning("Ficha Tecnica:\n".$ficha_tecnica);
            $ficha_tecnica->delete();
        }

        $cursos = Curso::where('id_pac', $id_pac)->get();
        logger()->warning("Cursos:\n".$cursos);

        foreach($cursos as $curso)
        {
            logger()->warning("Curso a borrar: ".$curso);
            $curso->delete();
        }
        
        logger("Borro todo");
    
        return response()->json($pac);
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

    public function getTabla(Request $request)
    {
        $query = Pac::select(
            'id_pac',
            'nombre',
            'id_accion',
            'ediciones',
            'duracion',
            'id_provincia',
            'id_ficha_tecnica',
            'created_at'
        )
        ->with([
            'tipoAccion' => function ($query) {
                return $query->withTrashed();
            },
            'provincias',
            'tematicas' => function ($query) {
                return $query->withTrashed();
            } 
        ])
        ->segunProvincia();
        
        return Datatables::of($query)->make(true);
    }

    public function getFiltradoPac(Request $request)
    {
        $filtros = collect($r->get('filtros'))
        ->mapWithKeys(function ($item) {
            return $item;
        });

        $query = Pac::select(
            'id_pac',
            'nombre',
            'id_accion',
            'edicion',
            'duracion',
            'id_provincia',
            'id_ficha_tecnica'
//            'created_at'
        )
        ->with([
            'tipoAccion',
            'provincias',
            'tematicas'
        ])
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

        return Datatables::of($query);
    }

    public function getSelectOptions()
    {
        $pautas = Cache::remember('pautas', 5, function () {
            return Pauta::all();
        });

        $componentes = Cache::remember('componentes', 5, function () {
            return Componente::all();
        });

        $destinatarios = Cache::remember('destinatarios', 5, function () {
            return Destinatario::all();
        });

        $responsables = Cache::remember('responsables', 5, function () {
            return Responsable::all();
        });

        $tematicas = Cache::remember('tematicas', 5, function () {
            return AreaTematica::all();
        });

        $tipoAcciones = Cache::remember('tipo_accion', 5, function () {
            return LineaEstrategica::all();
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

    public function getEditOptions()
    {
        $pautasEdit = Cache::remember('pautasEdit', 5, function () {
            return Pauta::withTrashed()->get();
        });

        $componentesEdit = Cache::remember('componentesEdit', 5, function () {
            return Componente::withTrashed()->get();
        });

        $destinatariosEdit = Cache::remember('destinatariosEdit', 5, function () {
            return Destinatario::withTrashed()->get();
        });

        $responsablesEdit = Cache::remember('responsablesEdit', 5, function () {
            return Responsable::withTrashed()->get();
        });

        $tematicasEdit = Cache::remember('tematicasEdit', 5, function () {
            return AreaTematica::withTrashed()->get();
        });

        $tipoAccionesEdit = Cache::remember('tipo_accionEdit', 5, function () {
            return LineaEstrategica::withTrashed()->get();
        });

        $provinciasEdit = Cache::remember('provinciasEdit', 5, function () {
            return Provincia::orderBy('nombre')->get();
        });

        return [
            'pautasEdit' => $pautasEdit,
            'componentesEdit' => $componentesEdit,
            'destinatariosEdit' => $destinatariosEdit,
            'responsablesEdit' => $responsablesEdit,
            'tematicasEdit' => $tematicasEdit,
            'tipoAccionesEdit' => $tipoAccionesEdit,
            'provinciasEdit' => $provinciasEdit
        ];
    }

    public function cambiarEstadoCursos($id_pac, $id_estado)
    {
        logger("Voy a actualizar los cursos del PAC: ".$id_pac ." al estado ".$id_estado);
        $cursos = Curso::where('id_pac', '=', $id_pac)->get();
        logger("Encontre estos cursos: " .$cursos);
        foreach($cursos as $curso)
        {
            logger("Encontre el curso: ".$curso);
            $curso->update(compact('id_estado'));
            logger("Actualice el curso: ".$curso);
        };
    }

    public function storeFichaTecnica(Request $request, $id_pac)
    {
        logger($id_pac);
        $path = $request->file('csv')->store('fichas_tecnicas');
        $path = explode('/', $path);
        $path = $path[1];
        $original = $request->file('csv')->getClientOriginalName();
        
        $ficha_tecnica = FichaTecnica::create(compact('original', 'path'));
        $id_ficha_tecnica = $ficha_tecnica->id_ficha_tecnica;
        logger("Cree la ficha tecnica: " .$ficha_tecnica);
        
        if($id_pac)
        { 
            $pac = Pac::findOrFail($id_pac);
            logger("Encontre el pac: " .$pac);

            $pac->update(compact('id_ficha_tecnica'));
            logger("Actualizo el pac: ".$pac);

            $this->cambiarEstadoCursos($id_pac, 2);
        }

        return $id_ficha_tecnica;
    }

    public function replaceFichaTecnica(Request $request, $id_ficha)
    {
        $path = $request->file('csv')->store('fichas_tecnicas');
        $path = explode('/', $path);
        $path = $path[1];
        $original = $request->file('csv')->getClientOriginalName();

        $ficha_tecnica = FichaTecnica::findOrFail($id_ficha);
        $replaced = $ficha_tecnica->path;

        $ficha_tecnica->update(compact('original', 'path'));

        Storage::delete($replaced);

        return response('Replaced', 200);
    }

    public function downloadFichaTecnica($id_ficha)
    {
        $ficha_tecnica = FichaTecnica::findOrFail($id_ficha);
        $path = storage_path("app/fichas_tecnicas/".$ficha_tecnica->path);
        return response()->download($path, $ficha_tecnica->original);
    }

    public function see($id_pac)
    {
        return view('pacs.modificacion', array_merge($this->show($id_pac), $this->getEditOptions(), ['disabled' => true]));
    }

    public function getPacWithTrashed($id_pac)
    {
        try {
            $pac = Pac::with([
                'cursos' => function ($query) {
                    return $query->withTrashed();
                },
                'destinatarios' => function ($query) {
                    return $query->withTrashed();
                },
                'pautas' => function ($query) {
                    return $query->withTrashed();
                },
                'responsables' => function ($query) {
                    return $query->withTrashed();
                },
                'componentes' => function ($query) {
                    return $query->withTrashed();
                },
                'tipoAccion' => function ($query) {
                    return $query->withTrashed();
                },
                'tematicas' => function ($query){
                    return $query->withTrashed();
                }])
                ->where('id_pac', $id_pac)->firstOrFail();

		    return ['pac' => $pac];
	    } catch (ModelNotFoundException $e) {
		    return response()->json(['success' => false, 'error' => $e->getMessage()]);
	    }
    }
    public function getCompletoExcel($id_pac)
    {
        $datos = $this->getPacWithTrashed($id_pac);
        $path = "pac_".$datos['pac']->nombre."_".$datos['pac']->provincias()->get()->first()->nombre."_".date("Y-m-d_H:i:s");
        Excel::create($path, function ($excel) use ($datos) {
            $excel->sheet('PAC', function ($sheet) use ($datos) {
                $sheet->setHeight(1, 20);
                $sheet->loadView('excel.pacCompleto', $datos);
            });
        })
        ->store('xls');
        return response()->download(storage_path("exports/{$path}.xls"))->deleteFileAfterSend(true);
    }

    public function getTablaFicha(Request $request, $id_pac)
    {
        $pac = Pac::with('fichaTecnica')
        ->where('id_pac', $id_pac)
        ->get();
        
        return Datatables::of($pac)->make(true);
    }

    public function getTablaEdiciones(Request $request, $id_pac)
    {
        $cursos = Curso::with('estado')
            ->where('id_pac', $id_pac)
            ->get();
        
        return Datatables::of($cursos)->make(true);
    }
}
