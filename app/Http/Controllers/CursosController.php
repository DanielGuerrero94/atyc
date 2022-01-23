<?php
/**
 * CursosController deberia llamar AccionesController
 *
 * @package Controllers
 * @author Daniel Guerrero
 **/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Cursos\AreaTematica;
use App\Models\Cursos\LineaEstrategica;
use App\Models\Cursos\Estado;
use App\Provincia;
use App\Periodo;
use App\Models\Cursos\Curso;
use DB;
use Auth;
use Validator;
use Datatables;
use Excel;
use PDF;
use Cache;

class CursosController extends AbmController
{
    /**
     * Rules for validate the request
     *
     * @var array
     **/
    private $rules = [
        'nombre'               => 'required|string',
        'duracion'             => 'required|numeric',
        'id_area_tematica'     => 'required|numeric',
        'id_linea_estrategica' => 'required|numeric',
        'id_provincia'         => 'required|numeric'
    ];

    /**
     * Filter rules
     *
     * @var array
     **/
    private $filters = [
        'nombre'               => 'string',
        'duracion'             => 'numeric',
        'edicion'              => 'numeric',
        'id_provincia'         => 'array',
        'id_linea_estrategica' => 'array',
        'id_area_tematica'     => 'array',
        'id_estado'            => 'array',
        'id_periodo'           => 'numeric',
        'desde'                => 'string',
        'hasta'                => 'string'
    ];

    /**
     * Icono de botones
     *
     * @var array
     **/
    private $botones = [
        'editar'   => 'fa fa-pencil-square-o',
        'eliminar' => 'fa fa-trash-o',
        'buscar'   => 'fa fa-search',
        'agregar'  => 'fa fa-plus-circle'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Curso::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cursos/alta', $this->getSelectOptions());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        logger('Quiere crear accion con: ' . json_encode($data));
        $v = Validator::make($data, $this->rules);

        if ($v->fails()) {
            return $v->errors();
        }

        //Calculo la edicion del curso, despues puede ser un trigger before insert
        $edicion = Curso::where([
                ['nombre', '=', $request->nombre],
                ['id_provincia', '=', $request->id_provincia],
            ])
                ->count() + 1;

        $data  =
            array_merge($data,
                ['edicion' => $edicion, 'id_estado' => 4, 'fecha_display' => $data['fecha_ejec_inicial']]);
        $curso = Curso::create($data);

        $areas_tematicas = explode(',', $request->get('id_area_tematica'));
        $curso->areasTematicas()->attach($areas_tematicas);

        if ($request->has('alumnos')) {
            $alumnos = explode(',', $request->get('alumnos'));
            $curso->alumnos()->attach($alumnos);
        }

        if ($request->has('profesores')) {
            $profesores = explode(',', $request->get('profesores'));
            $curso->profesores()->attach($profesores);
        }

        return $curso;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->getCursoWithTrashed($id);
    }

    public function getCursoWithTrashed($id)
    {
        try {
            $curso = Curso::with([
                'alumnos'          => function ($query) {
                    return $query->select(
                        'alumnos.id_alumno',
                        'nombres',
                        'apellidos',
                        'id_tipo_documento',
                        'nro_doc',
                        'id_provincia',
                        'id_genero',
                        'id_trabajo',
                        'id_funcion',
                        'email',
                        'tel',
                        'cel',
                        'localidad',
                        'establecimiento1',
                        'establecimiento2',
                        'organismo1',
                        'organismo2'
                    );
                },
                'profesores'       => function ($query) {
                    return $query->select(
                        'sistema.profesores.id_profesor',
                        'nombres',
                        'apellidos',
                        'id_tipo_documento',
                        'nro_doc',
                        'id_tipo_docente'
                    );
                },
                'lineaEstrategica' => function ($query) {
                    return $query->withTrashed();
                },
                'areaTematica'     => function ($query) {
                    return $query->withTrashed();
                }
            ])
                ->segunProvincia()
                ->where('id_curso', $id)
                ->firstOrFail();

            return ['curso' => $curso];
        } catch (ModelNotFoundException $e) {
            return ['response' => response()->json(['success' => false, 'error' => $e->getMessage()])];
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
        return view('cursos.modificacion', array_merge($this->getEditOptions(), $this->show($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $flag_update_pac = false)
    {
        logger("Quiere actualizar accion {$id} con: " . json_encode($request->all()));
        $curso = Curso::findOrFail($id);

        if ($request->has('alumnos')) {
            $curso->alumnos()->sync(explode(',', $request->get('alumnos')));
        } else {
            logger("Se deja el curso sin participantes");
            $curso->alumnos()->detach();
        }

        if ($request->has('profesores')) {
            $curso->profesores()->sync(explode(',', $request->get('profesores')));
        } else {
            logger("Se deja el curso sin docentes");
            $curso->profesores()->detach();
        }

        if ($request->has('error')) {
            logger()->warning('Curso ' . $id . ': No lleno la fecha de ejecucion o reprogramacion. Lo tiene que volver a intentar');
            return response('error');
        }

        $curso->update($request->all());

        if ($flag_update_pac) {
            $this->updateDisplayDatePac($curso);
        }

        return response()->json($curso);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $curso = Curso::findOrFail($id)->delete();
        return response()->json($curso);
    }

    /**
     * View para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        return view('cursos', $this->getEditOptions());
    }

    /**
     * View para abm con las planificadas prefiltradas.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPlanificados()
    {
        return view('cursos', array_merge($this->getEditOptions(), [
            'prefilters' => [
                Estado::CURSO_PLANIFICADO,
                Estado::CURSO_DISENIADO,
                Estado::CURSO_REPROGRAMADO
            ]
        ]));
    }

    /**
     * View para abm con las planificadas prefiltradas.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEjecutados()
    {
        return view('cursos', array_merge($this->getEditOptions(), [
            'prefilters' => [
                Estado::CURSO_EN_EJECUCION,
                Estado::CURSO_FINALIZADO
            ]
        ]));
    }

    public function getAprobadosPorAlumno($alumno)
    {
        $returns = Curso::whereHas('alumnos', function ($query) use ($alumno) {
            $query->where('alumnos.id_alumno', $alumno);
        })
            ->select('id_curso', 'nombre', 'duracion', 'id_provincia')
            ->with('provincia');

        return Datatables::of($returns)
            ->addColumn('acciones', function ($ret) {
                return '<a href="' . url('cursos') . '/' . $ret->id_curso . '"><button class="btn btn-info btn-xs" title="Ver">' .
                    '<i class="' . $this->botones['buscar'] . '" aria-hidden="true"></i></button></a>';
            })->make(true);
    }

    public function getDictadosPorProfesor($id_profesor)
    {
        $returns = Curso::whereHas('profesores', function ($query) use ($id_profesor) {
            $query->where('profesores.id_profesor', $id_profesor);
        })
            ->select('id_curso', 'nombre', 'fecha_ejec_inicial', 'id_provincia')
            ->with('provincia');

        return Datatables::of($returns)
            ->addColumn('acciones', function ($ret) {
                return '<a href="' . url('cursos') . '/' . $ret->id_curso . '"><button class="btn btn-info btn-xs" title="Ver">' .
                    '<i class="' . $this->botones['buscar'] . '" aria-hidden="true"></i></button></a>';
            })->make(true);
    }

    /**
     * Nombres de establecimientos para typeahead.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNombres()
    {
        $nombres = Curso::select('nombre')
            ->groupBy('nombre')
            ->orderBy('nombre')
            ->segunProvincia()
            ->get()
            ->map(function ($item, $key) {
                return $item->nombre;
            });

        return $this->typeaheadResponse($nombres);
    }

    public function getProfesores($id)
    {
        $curso = Curso::findOrFail($id)
            ->profesores()
            ->join(
                'sistema.tipos_documentos',
                'sistema.tipos_documentos.id_tipo_documento',
                '=',
                'sistema.profesores.id_tipo_documento'
            )
            ->select(
                'profesores.id_profesor',
                'nombres',
                'apellidos',
                'sistema.tipos_documentos.nombre as id_tipo_documento',
                'nro_doc'
            );

        return Datatables::of($curso)
            ->addColumn('acciones', function ($ret) {
                return '<a href="' . url('profesores/' . $ret['id_profesor']) . '"><button data-id="' . $ret['id_profesor'] .
                    '" class="btn btn-info btn-xs ver" title="Ver"><i class="' . $this->botones['editar'] .
                    '" aria-hidden="true"></i></button></a>';
            })
            ->make(true);
    }

    public function getAlumnos($id)
    {
        $curso = Curso::findOrFail($id)
            ->alumnos()
            ->join('sistema.provincias', 'sistema.provincias.id_provincia', '=', 'alumnos.id_provincia')
            ->join(
                'sistema.tipos_documentos',
                'sistema.tipos_documentos.id_tipo_documento',
                '=',
                'alumnos.alumnos.id_tipo_documento'
            )
            ->select(
                'alumnos.id_alumno',
                'nombres',
                'apellidos',
                'sistema.tipos_documentos.nombre as id_tipo_documento',
                'nro_doc',
                'sistema.provincias.nombre as provincia'
            );

        return Datatables::of($curso)
            ->addColumn('acciones', function ($ret) {
                return '<a href="' . url('alumnos/' . $ret['id_alumno']) . '"><button data-id="' . $ret['id_alumno'] .
                    '" class="btn btn-info btn-xs ver" title="Ver"><i class="' . $this->botones['buscar'] .
                    '" aria-hidden="true"></i></button></a>';
            })
            ->make(true);
    }

    public function getCountAlumnos(Request $request, $id)
    {
        $query = $this->queryCountAlumnos($request, $id);

        $cursos = DB::select($query);
        $cursos = collect($cursos);

        return Datatables::of($cursos)
            ->make(true);
    }

    private function queryCountAlumnos(Request $r, $id_provincia)
    {
        $query = "SELECT C.nombre,C.edicion,C.fecha_ejec_inicial,count (*) as cantidad_alumnos, CONCAT(LE.numero,'-',LE.nombre) as 
        linea_estrategica,AT.nombre as area_tematica,P.nombre as provincia,C.duracion from cursos.cursos C 
        left join cursos.cursos_alumnos CA ON CA.id_curso = C.id_curso 
        left join alumnos.alumnos A ON CA.id_alumno = A.id_alumno
        inner join sistema.provincias P ON P.id_provincia = C.id_provincia
        inner join cursos.areas_tematicas AT ON AT.id_area_tematica = C.id_area_tematica 
        inner join cursos.lineas_estrategicas LE ON LE.id_linea_estrategica = C.id_linea_estrategica";

        if ($id_provincia !== '0' and $id_provincia !== 25) {
            $query .= " WHERE C.id_provincia = '" . $id_provincia . "'";
        }

        $query .= "group by C.id_curso,C.nombre,LE.numero,LE.nombre,AT.nombre,P.nombre";

        return $query;
    }

    public function getAlumnosDeCursosPorProvincia($id_provincia)
    {
        return Curso::segunProvincia()->with('alumnos')->get();
    }

    /**
     * Opciones para los selects del front end.
     *
     * @return array
     */
    private function getSelectOptions()
    {
        $areas_tematicas = Cache::remember('areas', 5, function () {
            return AreaTematica::orderBy('nombre')->get();
        });

        $lineas_estrategicas = Cache::remember('lineas', 5, function () {
            return LineaEstrategica::orderBy('numero')->get();
        });

        $provincias = Cache::remember('provincias', 5, function () {
            return Provincia::orderBy('nombre')->get();
        });

        $periodos = Cache::remember('periodos', 5, function () {
            return Periodo::orderBy('hasta', 'desc')->orderBy('desde')->orderBy('id_periodo', 'desc')->get();
        });

        $estados = Cache::remember('estados', 5, function () {
            return Estado::orderBy('id_estado')->get();
        });

        return compact('areas_tematicas', 'lineas_estrategicas', 'provincias', 'periodos', 'estados');
    }

    private function getEditOptions()
    {
        $areas_tematicas_edit = Cache::remember('areas_edit', 5, function () {
            return AreaTematica::orderBy('deleted_at', 'desc')->orderBy('nombre')->withTrashed()->get();
        });

        $lineas_estrategicas_edit = Cache::remember('lineas_edit', 5, function () {
            return LineaEstrategica::orderBy('deleted_at', 'desc')->orderBy('numero')->withTrashed()->get();
        });

        $provincias_edit = Cache::remember('provincias_edit', 5, function () {
            return Provincia::orderBy('nombre')->get();
        });

        $periodos_edit = Cache::remember('periodos_edit', 5, function () {
            return Periodo::orderBy('hasta', 'desc')->orderBy('desde')->orderBy('id_periodo', 'desc')->get();
        });

        $estados_edit = Cache::remember('estados_edit', 5, function () {
            return Estado::orderBy('id_estado')->get();
        });

        return compact('areas_tematicas_edit', 'lineas_estrategicas_edit', 'provincias_edit', 'periodos_edit',
            'estados_edit');
    }

    public function logFiltro($key, $value)
    {
        if (is_array($value)) {
            $value = implode(", ", $value);
        }
        logger()->info($key . ": " . $value);
    }

    private function queryFechasCurso($query, $signo, $fecha)
    {
        $query->orWhere('cursos.cursos.fecha_ejec_inicial', $signo, $fecha)
            ->orWhere('cursos.cursos.fecha_ejec_final', $signo, $fecha)
            ->orWhere(function ($q) use ($signo, $fecha) {
                $q->where('cursos.cursos.fecha_plan_inicial', '!=', null)
                    ->where('cursos.cursos.fecha_plan_inicial', $signo, $fecha)
                    ->where('cursos.cursos.fecha_plan_final', '!=', null)
                    ->where('cursos.cursos.fecha_plan_final', $signo, $fecha);
            });
    }

    private function queryLogica(Request $r, $filtros, $order_by)
    {
        ini_set('max_execution_time', '300');

        //Filtros las que estan vacias si es que me las pasaron
        $filtered = $filtros->filter(function ($value, $key) {
            return $value != "" && $value != "0";
        });

        logger()->warning(json_encode($filtered));

        $query = Curso::with([
            'provincia',
            'estado',
            'areasTematicas'   => function ($query) {
                return $query->withTrashed();
            },
            'areaTematica'     => function ($query) {
                return $query->withTrashed();
            },
            'lineaEstrategica' => function ($query) {
                return $query->withTrashed();
            },
            'pac'              => function ($query) {
                return $query->withTrashed()->with('fichaTecnica');
            }
        ])
            ->segunProvincia();

        foreach ($filtered as $key => $value) {
            $this->logFiltro($key, $value);
            if ($key == 'nombre') {
                $query = $query->where('cursos.cursos.' . $key, 'ilike', "%{$value}%");
            } elseif ($key == 'desde') {
                $query = $query->where(function ($q) use ($value) {
                    $this->queryFechasCurso($q, '>=', $value);
                });
            } elseif ($key == 'hasta') {
                $query = $query->where(function ($q) use ($value) {
                    $this->queryFechasCurso($q, '<=', $value);
                });
            } elseif ($key == 'id_periodo') {
                $periodo = Periodo::find($value);
                $query   = $query->where(function ($q) use ($periodo) {
                    $this->queryFechasCurso($q, '>=', $periodo->desde);
                });

                $query = $query->where(function ($q) use ($periodo) {
                    $this->queryFechasCurso($q, '<=', $periodo->hasta);
                });
            } elseif ($key == 'duracion' || $key == 'edicion') {
                $query = $query->where('cursos.cursos.' . $key, $value);
            } else {
                $query = $query->whereIn('cursos.cursos.' . $key, $value);
            }
        }

        if (isset($order_by)) {
            $ordenadores =
                [
                    'fecha_display',
                    'nombre',
                    'id_estado',
                    'edicion',
                    'duracion',
                    'id_tematica',
                    'id_linea_estrategica',
                    'id_provincia'
                ];

            // logger()->info("order_by[0][1]: ".$order_by['order_by'][0][1]);
            // logger()->info("ordenador[order_by[0][0]]: ".$ordenadores[$order_by['order_by'][0][0]]); 

            $query = $query->orderBy($ordenadores[$order_by['order_by'][0][0]], $order_by['order_by'][0][1]);
        }

        return $query;
    }

    public function getFiltrado(Request $r)
    {
        $filtros = collect($r->only('filtros'));
        $filtros = collect($filtros->get('filtros'));

        $v = Validator::make($filtros->all(), $this->filters);
        if (!$v->fails()) {
            $query = $this->queryLogica($r, $filtros, null);

            return $this->toDatatable($r, $query);
        } else {
            return json_encode($v->errors());
        }
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

                $accion = $r->has('botones') ? $r->botones : null;

                $editarYEliminar =
                    '<a href="' . url('cursos') . '/' . $ret->id_curso . '"><button data-id="' . $ret->id_curso .
                    '" class="btn btn-info btn-xs editar" title="Editar"><i class="' . $this->botones['editar'] .
                    '" aria-hidden="true"></i></button></a>' . '<button data-id="' . $ret->id_curso .
                    '" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="' . $this->botones['eliminar'] .
                    '" aria-hidden="true"></i></button>';

                $agregar = '<button data-id="' . $ret->id_curso . '" class="btn btn-info btn-xs agregar" ' .
                    'title="Agregar"><i class="' . $this->botones['agregar'] . '" aria-hidden="true"></i></button>';

                return $accion == 'agregar' ? $agregar : $editarYEliminar;
            })
            ->make(true);
    }

    /**
     * Corre la query segun filtros y order_by
     * Guarda el resultado en un .xls
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response  path al archivo generado
     */
    public function getExcel(Request $r)
    {
        $filtros = collect($r->only('filtros'));
        $filtros = collect($filtros->get('filtros'));

        $order_by = collect($r->only('order_by'));

        $data  = $this->queryLogica($r, $filtros, $order_by)->get()->toArray();
        $datos = ['cursos' => $data];
        $path  = "acciones_" . date("Y-m-d_H:i:s");

        Excel::create($path, function ($excel) use ($datos) {
            $excel->sheet('Acciones', function ($sheet) use ($datos) {
                $sheet->setHeight(1, 20);
                $sheet->loadView('excel.cursos', $datos);
            });
        })
            ->store('xls');

        return $path;
    }

    /**
     * Corre la query segun filtros y order_by
     * Guarda el resultado en un .pdf
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response  path al archivo generado
     */
    public function getPDF(Request $r)
    {
        $filtros = collect($r->only('filtros'));
        $filtros = collect($filtros->get('filtros'));

        $data = $this->queryLogica($r, $filtros, null)->get();

        $header      =
            array('Nombre', 'Fecha', 'Edicion', 'Duracion', 'Area Tematica', 'Linea Estrategica', 'Provincia');
        $column_size = array(80, 25, 15, 17, 60, 60, 20);

        $mapped = $data->map(function ($item, $key) {
            return [
                $item->nombre,
                $item->fecha_ejec_inicial,
                $item->edicion,
                $item->duracion,
                $item->area_tematica,
                $item->linea_estrategica,
                $item->provincia
            ];
        });
        return PDF::save($header, $column_size, 10, $mapped);
    }

    /**
     * Corre la query para el reporte (No deberia estar aca)
     * Guarda el resultado en un .xls
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response path al archivo generado
     */
    public function getExcelReporte(Request $r)
    {
        if (array_key_exists('id_provincia', $r->filtros)) {
            $id_provincia = $r->filtros['id_provincia'];
        } else {
            $id_provincia = Auth::user()->id_provincia;
        }
        $data  = DB::select($this->queryCountAlumnos($r, $id_provincia));
        $data  = collect($data);
        $datos = ['cursos' => $data];
        $path  = "cant_participantes_acciones_" . date("Y-m-d_H:i:s");

        Excel::create($path, function ($excel) use ($datos) {
            $excel->sheet('Reporte', function ($sheet) use ($datos) {
                $sheet->setHeight(1, 20);
                $sheet->loadView('excel.reporte_6', $datos);
            });
        })
            ->store('xls');

        return $path;
    }

    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response xls file
     **/
    public function getCompletoExcel($id)
    {
        $datos = $this->getCursoWithTrashed($id);
        $path  = "accion_completa_" . date("Y-m-d_H:i:s");
        Excel::create($path, function ($excel) use ($datos) {
            $excel->sheet('Accion', function ($sheet) use ($datos) {
                $sheet->setHeight(1, 20);
                $sheet->loadView('excel.cursoCompleto', $datos);
            });
        })
            ->store('xls');
        return response()->download(storage_path("exports/{$path}.xls"))->deleteFileAfterSend(true);
    }

    /**
     * Show the form for seeing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function see($id)
    {
        return view('cursos/modificacion',
            array_merge($this->show($id), $this->getEditOptions(), ['disabled' => true]));
    }

    public function updateDisplayDatePac(Curso $curso)
    {
        $pac = $curso->pac()->first();
        return app('App\Http\Controllers\PacController')->setDisplayDate($pac);
    }

    public function ejecutar(Request $request, $id)
    {
        logger()->info("Ejecuto el curso: " . $id);
        return $this->update($request, $id, $flag_update_pac = true);
    }

    public function reprogramar(Request $request, $id)
    {
        logger()->info("Reprogramo el curso: " . $id);
        return $this->update($request, $id, $flag_update_pac = true);
    }

    public function desactivar(Request $request, $id)
    {
        logger()->info("Desactivo el curso: " . $id);
        return $this->update($request, $id, $flag_update_pac = true);
    }

    public function addAlumno(Request $request, $id)
    {
        $alumnoId = $request->get('alumno_id');

        $curso = Curso::findOrFail($id);

        $curso->alumnos()->sync(
            array_merge($curso->alumnos->pluck('id_alumno')->toArray(), [$alumnoId])
        );

        return response()->json($curso);
    }

    public function removeAlumno(Request $request, $id)
    {
        $alumnoId = $request->get('alumno_id');

        $curso = Curso::findOrFail($id);

        $curso->alumnos()->sync(
            array_diff($curso->alumnos->pluck('id_alumno')->toArray(), [$alumnoId])
        );

        return response()->json($curso);
    }

    public function addProfesor(Request $request, $id)
    {
        $profesorId = $request->get('profesor_id');

        $curso = Curso::findOrFail($id);

        $curso->profesores()->sync(
            array_merge($curso->profesores->pluck('id_profesor')->toArray(), [$profesorId])
        );

        return response()->json($curso);
    }

    public function removeProfesor(Request $request, $id)
    {
        $profesorId = $request->get('profesor_id');

        $curso = Curso::findOrFail($id);

        $curso->profesores()->sync(
            array_diff($curso->profesores->pluck('id_profesor')->toArray(), [$profesorId])
        );

        return response()->json($curso);
    }
}
