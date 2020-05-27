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
use Carbon\Carbon;

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
        'nombre' => 'string',
        'duracion' => 'numeric',
        'ediciones' => 'numeric'
        // 'id_periodo' => 'numeric',
        // 'desde' => 'string',
        // 'hasta' => 'string'
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
        $data['ficha_obligatoria'] = true;
        
        $pac = Pac::create($data);
        logger('Crea pac: '.$pac);

        $this->attachPivotTables($pac, $request);
        $this->crearCursos($pac, $request);

        $id_ficha_tecnica = $request->get('id_ficha_tecnica');
        logger('id_ficha_tecnica: '.$id_ficha_tecnica);

        if($id_ficha_tecnica)
            $this->cambiarEstadoCursos($pac->id_pac, 2);
        
        $this->setDisplayDate($pac);

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
        return view('pacs', $this->getEditOptions());
    }

    public function logFiltro($key, $value)
    {
        if(is_array($value))
            $value = implode(", ", $value);
        logger()->info($key.": ".$value);
    }

    public function queryLogicaIds($filtros)
    {
        $filtered = $filtros->filter(function ($value, $key) {
            return $value != "" && $value != "0";
        });

        logger()->warning(json_encode($filtered));

        $query = DB::table('pac.pac_joined');

        foreach ($filtered as $key => $value) {
            $this->logFiltro($key, $value);

            if($key == 'ficha_tecnica_aprobada')
            {
                $query = $query->where(function($q) use ($key, $value) {
                    if (in_array("no_tiene", $value))
                    {
                        $q->orWhere('pac.pac_joined.id_ficha_tecnica', null);
                        $value = array_diff($value,["no_tiene"]);
                    }

                    $q = $q->orWhereIn('pac.pac_joined.'.$key, $value);
                });
            }
            elseif ($key == 'desde')
            {
                $query = $query->where(function($q) use ($value) {
                    $q->orWhere('pac.pac_joined.fp_desde', '>=', $value)
                    ->orWhere('pac.pac_joined.fp_hasta', '>=', $value);
                    //->orWhere('pac.pac_joined_fe_desde', '>=', $value)
                    //->orWhere('pac.pac_joined_fe_hasta', '>=', $value);
                });
            }
            elseif ($key == 'hasta')
            {
                $query = $query->where(function($q) use ($value) {
                    $q->orWhere('pac.pac_joined.fp_desde', '<=', $value)
                    ->orWhere('pac.pac_joined.fp_hasta', '<=', $value);
                    //->orWhere('pac.pac_joined_fe_desde', '<=', $value)
                    //->orWhere('pac.pac_joined_fe_hasta', '<=', $value);
                });
            }
            elseif ($key == 'periodo')
            {
                $periodo = Periodo::find($value);

                $query = $query->where(function($q) use ($periodo) {
                    $q->orWhere('pac.pac_joined.fp_desde', '>=', $periodo->desde)
                    ->orWhere('pac.pac_joined.fp_hasta', '>=', $periodo->desde);
                    //->orWhere('pac.pac_joined.fe_desde', '>=', $periodo->desde)
                    //->orWhere('pac.pac_joined.fe_hasta', '>=', $periodo->desde);
                });

                $query = $query->where(function($q) use ($periodo) {
                    $q->orWhere('pac.pac_joined.fp_desde', '<=', $periodo->hasta)
                    ->orWhere('pac.pac_joined.fp_hasta', '<=', $periodo->hasta);
                    //->orWhere('pac.pac_joined_fe_desde', '<=', $periodo->hasta)
                    //->orWhere('pac.pac_joined_fe_hasta', '<=', $periodo->hasta);
                });
            }
            elseif ($key == 'nombre')
                $query = $query->where('pac.pac_joined.'.$key, 'ilike', "%{$value}%");
            elseif ($key == 'ediciones' || $key == 'duracion')
                $query = $query->where('pac.pac_joined.'.$key, $value);
            else
                $query = $query->whereIn('pac.pac_joined.'.$key, $value);
        }

        logger()->warning("query: ".json_encode($query->toSql()));

        $ids = $query->select('id_pac')->distinct()->get()->toArray();

        $ids = array_map(function ($val) {
            return $val->id_pac;
        }, $ids);
         
        logger()->warning("ids_pac: ".json_encode($ids));

        return $ids;
    }

    function getTabla($ids_pac, $order_by)
    {
        $pacs = Pac::with([
            'tipoAccion' => function ($pacs) {
                return $pacs->withTrashed();
            },
            'provincias',
            'tematicas' => function ($pacs) {
                return $pacs->withTrashed();
            },
            'cursos' => function ($pacs) {
                return $pacs->withTrashed();
            },
            'fichaTecnica' => function ($pacs) {
                return $pacs->withTrashed();
            },
            'responsables' => function ($pacs) {
                return $pacs->withTrashed();
            }
        ])
        ->whereIn('pac.pacs.id_pac', $ids_pac)
        ->segunProvincia();

        foreach ($pacs->get() as $pac)
            $this->setDisplayDate($pac);
        
        if(isset($order_by))
        {
            $ordenadores = ['display_date', 'nombre', 'ediciones', 'duracion', 'id_ficha_tecnica', 'id_provincia'];

            logger()->info("order_by[0][1]: ".$order_by['order_by'][0][1]);
            logger()->info("ordenador[order_by[0][0]]: ".$ordenadores[$order_by['order_by'][0][0]]); 

            $pacs = $pacs->orderBy($ordenadores[$order_by['order_by'][0][0]], $order_by['order_by'][0][1]);
        }

        logger()->warning("pacs: ".json_encode($pacs->toSql()));

        return $pacs;
    }

    public function setDisplayDate(Pac $pac)
    {
        $cursos = $pac->cursos()->orderBy('fecha_plan_inicial')->get();

        $todos_ejecutados = true;
        $estados = array();

        //logger()->warning("Pac: ".$pac->nombre);

        foreach ($cursos as $curso) 
        {
            if(isset($curso->fecha_ejec_inicial))
            {
                if((!isset($fecha_ejec_anterior) || $curso->fecha_ejec_inicial <= $fecha_ejec_anterior))
                    $fecha_ejec_anterior = $curso->fecha_ejec_inicial;
            }
            else
            {
                $todos_ejecutados = false;
                
                if($curso->fecha_plan_inicial >= Carbon::now()->format('yy-m-d') && (!isset($fecha_plan_posterior) || $curso->fecha_plan_inicial <= $fecha_plan_posterior))
                    $fecha_plan_posterior = $curso->fecha_plan_inicial;
                
                elseif(!isset($fecha_plan_anterior) || $curso->fecha_plan_inicial <= $fecha_plan_anterior)
                    $fecha_plan_anterior = $curso->fecha_plan_inicial;
            }

            // logger()->warning("Comparacion: ".$curso->fecha_plan_inicial." >= ".Carbon::now()->format('yy-m-d'));
            // if(isset($fecha_plan_anterior))
            //     logger()->warning("Fecha Plan Anterior: ".$fecha_plan_anterior);
            // if(isset($fecha_plan_posterior))
            //     logger()->warning("Fecha Plan Posterior: ".$fecha_plan_posterior);
            // if(isset($fecha_ejec_anterior))
            //     logger()->warning("Fecha Ejec Anterior: ".$fecha_ejec_anterior);
        }
        $display = $pac->created_at;
        
        if(isset($fecha_plan_posterior))
            $display = $fecha_plan_posterior;
        elseif($todos_ejecutados && isset($fecha_ejec_anterior))
            $display = $fecha_ejec_anterior;
        elseif(isset($fecha_plan_anterior))
            $display = $fecha_plan_anterior;

        $pac->display_date = $display;
        $pac->save();
        // logger()->warning("display_date :".$pac->display_date);
    }

    public function setColorEstado($id_estado)
    {
        $color = "progress-bar";

        $estados = ['warning', 'info', 'ejecutando', 'success', 'reprogramado', 'danger'];

        return $color.'-'.$estados[$id_estado - 1];
    }

    public function estadosPorCursos(Pac $pac)
    {
        $cursos = $pac->cursos()->get();
        $estados = array();

        foreach ($cursos as $curso)
        {
            if(!isset($estados[$curso->id_estado]))
            {
                $estados[$curso->id_estado]['cantidad'] = 1;
                $estados[$curso->id_estado]['titulo'] = $curso->estado()->get()[0]->nombre;
                $estados[$curso->id_estado]['color'] = $this->setColorEstado($curso->id_estado);
                $estados[$curso->id_estado]['porcentaje'] = 100;
            }
            else {
                $estados[$curso->id_estado]['cantidad']++;
            }
        }

        foreach($estados as &$estado)
            $estado['porcentaje'] = ($estado['cantidad'] / $cursos->count()) * 100;

        // logger()->warning("Pac: ".$pac->nombre);
        // logger()->warning("Estados: ".json_encode($estados));

        return $estados;
    }

    public function getFiltrado(Request $r)
    {
        $filtros = collect($r->only('filtros'));
        $filtros = collect($filtros->get('filtros'));

        $v = Validator::make($filtros->all(), $this->filters);
        if (!$v->fails()) {
            $ids_pac = $this->queryLogicaIds($filtros);
            $pacs = $this->getTabla($ids_pac, null);

            return Datatables::of($pacs)
            ->addColumn(
                'estados_por_curso', function (Pac $pac) {
                    return $this->estadosPorCursos($pac);
            })
            ->make(true);
        } else {
            return json_encode($v->errors());
        }
    }

    public function getAniosyProvinciasPac($pacs)
    {
        $anios = array();
        $provincias = array();
        foreach($pacs as $pac)
        {
            $anios[] = $pac->anio;
            $provincias[] = $pac->provincias()->get()->first()->nombre;
        }
        $anios = implode("-", array_unique($anios));
        $provincias = implode("-", array_unique($provincias));

        return ['anios' => $anios, 'provincias' => $provincias];
    }

    public function getExcel(Request $r)
    {
        $filtros = collect($r->only('filtros'));
        $filtros = collect($filtros->get('filtros'));

        $order_by = collect($r->only('order_by'));

        $ids_pac = $this->queryLogicaIds($filtros);

        $pacs = $this->getTabla($ids_pac, $order_by)->get();
        $data_extra = $this->getAniosyProvinciasPac($pacs);

        $datos = ['pacs' => $pacs];
        $path = "pacs_".$data_extra['anios'].'_'.$data_extra['provincias'].'_'.date("Y-m-d_H:i:s");

        Excel::create($path, function ($excel) use ($datos) {
            $excel->sheet('PAC', function ($sheet) use ($datos) {
                $sheet->setHeight(1, 20);
                $sheet->loadView('excel.pacs', $datos);
            });
        })
        ->store('xls');

        return $path;
    }

    /**
     * Opciones para los selects del front end.
     *
     * @return array
     */

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
            return AreaTematica::orderBy('nombre')->get();
        });

        $tipoAcciones = Cache::remember('tipo_accion', 5, function () {
            return LineaEstrategica::orderBy('numero')->get();
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
            return Pauta::orderBy('deleted_at', 'desc')->orderBy('nombre')->withTrashed()->get();
        });

        $componentesEdit = Cache::remember('componentesEdit', 5, function () {
            return Componente::orderBy('deleted_at', 'desc')->orderBy('nombre')->withTrashed()->get();
        });

        $destinatariosEdit = Cache::remember('destinatariosEdit', 5, function () {
            return Destinatario::orderBy('deleted_at', 'desc')->orderBy('nombre')->withTrashed()->get();
        });

        $responsablesEdit = Cache::remember('responsablesEdit', 5, function () {
            return Responsable::orderBy('deleted_at', 'desc')->orderBy('nombre')->withTrashed()->get();
        });

        $tematicasEdit = Cache::remember('tematicasEdit', 5, function () {
            return AreaTematica::orderBy('deleted_at', 'desc')->orderBy('nombre')->withTrashed()->get();
        });

        $tipoAccionesEdit = Cache::remember('tipo_accionEdit', 5, function () {
            return LineaEstrategica::orderBy('deleted_at', 'desc')->orderBy('numero')->withTrashed()->get();
        });

        $provinciasEdit = Cache::remember('provinciasEdit', 5, function () {
            return Provincia::orderBy('nombre')->get();
        });

        $periodos = Cache::remember('periodos', 5, function () {
            return Periodo::all();
        });

        return [
            'pautasEdit' => $pautasEdit,
            'componentesEdit' => $componentesEdit,
            'destinatariosEdit' => $destinatariosEdit,
            'responsablesEdit' => $responsablesEdit,
            'tematicasEdit' => $tematicasEdit,
            'tipoAccionesEdit' => $tipoAccionesEdit,
            'provinciasEdit' => $provinciasEdit,
            'periodos' => $periodos
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
        $aprobada = false;
        
        $ficha_tecnica = FichaTecnica::create(compact('original', 'path', 'aprobada'));
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

    public function aprobarFichaTecnica($id_ficha)
    {
        $ficha_tecnica = FichaTecnica::findOrFail($id_ficha);
        $ficha_tecnica->aprobada = true;
        $ficha_tecnica->save();

        return response('Aprobada');
    }

    public function desaprobarFichaTecnica($id_ficha)
    {
        $ficha_tecnica = FichaTecnica::findOrFail($id_ficha);
        $ficha_tecnica->aprobada = false;
        $ficha_tecnica->save();

        return response('Desaprobada');
    }

    public function obligarFichaTecnica($id_pac)
    {
        $pac = Pac::findOrFail($id_pac);
        $pac->ficha_obligatoria = true;
        $pac->save();

        return response('Obligado');
    }

    public function desobligarFichaTecnica($id_pac)
    {
        $pac = Pac::findOrFail($id_pac);
        $pac->ficha_obligatoria = false;
        $pac->save();

        return response('Desobligado');
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
                ->segunProvincia()
                ->where('id_pac', $id_pac)->firstOrFail();

		    return ['pac' => $pac];
	    } catch (ModelNotFoundException $e) {
		    return ['response' => response()->json(['success' => false, 'error' => $e->getMessage()])];
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
