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
        'nombre' => 'required|string',
        'duracion' => 'required|numeric',
        'id_area_tematica' => 'required|numeric',
        'id_linea_estrategica' => 'required|numeric',
        'id_provincia' => 'required|numeric'
    ];

    /**
     * Filter rules
     *
     * @var array
     **/
    private $filters = [
        'nombre' => 'string',
        'duracion' => 'numeric',
        'edicion' => 'numeric',
        'id_provincia' => 'numeric',
        'id_linea_estrategica' => 'numeric',
        'id_area_tematica' => 'numeric',
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
        logger('Quiere crear accion con: '.json_encode($data));
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

        $data = array_merge($data, ['edicion' => $edicion]);
        $curso = Curso::create($data);

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
                'alumnos' => function ($query) {
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
                'profesores' => function ($query) {
                    return $query->select(
                        'sistema.profesores.id_profesor',
                        'nombres',
                        'apellidos',
                        'id_tipo_documento',
                        'nro_doc'
                    );
                },
                'lineaEstrategica' => function ($query) {
                    return $query->withTrashed();
                },
                'areaTematica' => function ($query) {
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
    public function update(Request $request, $id)
    {
        logger("Quiere actualizar accion {$id} con: ".json_encode($request->all()));
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
        
        $curso->update($request->all());
        return $curso;
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
        return view('cursos', $this->getSelectOptions());
    }

    /**
     * Devuelve la informacion para abm.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTabla(Request $request)
    {
        $query = Curso::select(
            'id_curso',
            'nombre',
            'fecha_ejec_inicial',
            'fecha_ejec_final',
            'fecha_plan_inicial',
            'fecha_plan_final',
            'edicion',
            'duracion',
            'id_area_tematica',
            'id_linea_estrategica',
            'id_provincia',
            'id_estado',
            'created_at'
        )
        ->with([
            'provincia',
            'estado',
            'areaTematica' => function ($query) {
                return $query->withTrashed();
            },
            'lineaEstrategica' => function ($query) {
                return $query->withTrashed();
            }
        ])
        //->withCount('alumnos')
        ->segunProvincia();

        //logger()->warning(json_encode($query->first()));

        return $this->toDatatable($request, $query);
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
            return '<a href="'.url('cursos').'/'.$ret->id_curso.'"><button class="btn btn-info btn-xs" title="Ver">'.
            '<i class="'.$this->botones['buscar'].'" aria-hidden="true"></i></button></a>';
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
            return '<a href="'.url('cursos').'/'.$ret->id_curso.'"><button class="btn btn-info btn-xs" title="Ver">'.
            '<i class="'.$this->botones['buscar'].'" aria-hidden="true"></i></button></a>';
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
            return '<a href="'.url('profesores/'.$ret['id_profesor']).'"><button data-id="'.$ret['id_profesor'].
            '" class="btn btn-info btn-xs ver" title="Ver"><i class="'.$this->botones['editar'].
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
            return '<a href="'.url('alumnos/'.$ret['id_alumno']).'"><button data-id="'.$ret['id_alumno'].
            '" class="btn btn-info btn-xs ver" title="Ver"><i class="'.$this->botones['buscar'].
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
            $query .= " WHERE C.id_provincia = '".$id_provincia."'";
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
            return Periodo::all();
        });

        return compact('areas_tematicas', 'lineas_estrategicas', 'provincias', 'periodos');
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
            return Periodo::all();
        });

        return compact('areas_tematicas_edit', 'lineas_estrategicas_edit', 'provincias_edit', 'periodos_edit');
    }

    private function queryLogica(Request $r, $filtros, $orderBy)
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
            'areaTematica' => function ($query) {
                return $query->withTrashed();
            },
            'lineaEstrategica' => function ($query) {
                return $query->withTrashed();
            }])
        //->withCount('alumnos')
        ->segunProvincia();

        foreach ($filtered as $key => $value) {
            if ($key == 'nombre') {
                $query = $query->where('cursos.cursos.'.$key, 'ilike', "%{$value}%");
            } elseif ($key == 'desde') {
                $query = $query->where('cursos.cursos.fecha_ejec_inicial', '>=', $value);
            } elseif ($key == 'hasta') {
                $query = $query->where('cursos.cursos.fecha_ejec_inicial', '<=', $value);
            } elseif ($key == 'id_periodo') {
                $periodo = Periodo::find($value);
                $query = $query->where('cursos.cursos.fecha_ejec_inicial', '>=', $periodo->desde);
                $query = $query->where('cursos.cursos.fecha_ejec_inicial', '<=', $periodo->hasta);
            } else {
                $query = $query->where('cursos.cursos.'.$key, $value);
            }
        }

        return $query->orderBy('fecha_ejec_inicial','desc');
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

            $accion = $r->has('botones')?$r->botones:null;

            $editarYEliminar = '<a href="'.url('cursos').'/'.$ret->id_curso.'"><button data-id="'.$ret->id_curso.
            '" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones['editar'].
            '" aria-hidden="true"></i></button></a>'.'<button data-id="'.$ret->id_curso.
            '" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="'.$this->botones['eliminar'].
            '" aria-hidden="true"></i></button>';
            
            $agregar = '<button data-id="'.$ret->id_curso.'" class="btn btn-info btn-xs agregar" '.
            'title="Agregar"><i class="'.$this->botones['agregar'].'" aria-hidden="true"></i></button>';

            return $accion == 'agregar'?$agregar:$editarYEliminar;
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

        $data = $this->queryLogica($r, $filtros, $order_by)->get();
        $datos = ['cursos' => $data];
        $path = "acciones_".date("Y-m-d_H:i:s");

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

        $header = array('Nombre','Fecha','Edicion','Duracion','Area Tematica','Linea Estrategica','Provincia');
        $column_size =  array(80,25,15,17,60,60,20);

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
        $data = DB::select($this->queryCountAlumnos($r, $id_provincia));
        $data = collect($data);
        $datos = ['cursos' => $data];
        $path = "cant_participantes_acciones_".date("Y-m-d_H:i:s");

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
        $path = "accion_completa_".date("Y-m-d_H:i:s");
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function see($id)
    {
        return view('cursos/modificacion', array_merge($this->show($id), $this->getEditOptions(), ['disabled' => true]));
    }

    public function ejecutar(Request $request, $id)
    {
        if($request->has('error'))
        {
            logger()->warning('Ejecutar Curso '.$id.': No lleno las fechas de ejecucion');
            return response('error');
        }
        $curso = $this->update($request, $id);
        logger()->info("Ejecute el curso: ".json_encode($curso));

        return response()->json($curso);
    }

    public function reprogramar(Request $request, $id)
    {
        if($request->has('error'))
        {
            logger()->warning('Reprogamar Curso '.$id.': No lleno las fechas de reprogramacion');
            return response('error');
        }
        $curso = $this->update($request, $id);
        logger()->info("Reprograme el curso: ".json_encode($curso));

        return response()->json($curso);
    }

    public function desactivar(Request $request, $id)
    {
        $curso = $this->update($request, $id);
        logger()->info("Desactive el curso: ".json_encode($curso));

        return response()->json($curso);
    }
}
