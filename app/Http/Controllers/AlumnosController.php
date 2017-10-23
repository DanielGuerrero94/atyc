<?php
/**
 * AlumnosController se deberia llamar ParticipantesController
 *
 * @package Controllers
 * @author Daniel Guerrero
 **/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno;
use App\Provincia;
use App\Pais;
use App\Funcion;
use App\Trabajo;
use App\TipoDocumento;
use App\Genero;
use Cache;
use Validator;
use Datatables;
use Excel;
use App\PDF as Pdf;
use DB;
use Auth;
use Log;
use App\Http\Controllers\EfectoresController;

//Exceptions
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AlumnosController extends AbmController
{
    /**
     * Rules for the validator
     *
     * @var string
     **/
    private $rules = [
        'nombres' => 'required|string',
        'apellidos' => 'required|string',
        'id_tipo_documento' => 'required|numeric',
        'pais' => 'required_if:id_tipo_documento,5,6',
        'nro_doc' => 'required|numeric',
        'localidad' => 'required|string',
        'id_provincia' => 'required|numeric',
        'id_trabajo' => 'required|numeric',
        'id_genero' => 'required|numeric',
        'id_funcion' => 'required_if:id_trabajo,2,3|numeric',
    //'establecimiento' => 'required_if:id_trabajo,2|required_if:id_trabajo,2|string',
        'tipo_convenio' => 'nullable',
        'efector' => 'required_with:tipo_convenio|string',
        'tipo_organismo' => 'required_if:id_trabajo,3|string',
        'nombre_organismo' => 'required_if:id_trabajo,3|string',
        'email' => 'nullable|email',
        'tel' => 'nullable',
        'cel' => 'nullable'
    ];

    private $filters = [
        'nombres' => 'string',
        'apellidos' => 'string',
        'id_tipo_documento' => 'numeric',
        'id_provincia' => 'numeric',
        'id_genero' => 'numeric',
        'cel' => 'numeric',
        'tel' => 'numeric',
    //Tiene que ser string porque si en el filtro no quieren ponerlo completo yo lo comparo con un ilike
        'email' => 'string',
        'localidad' => 'string',
        'nro_doc' => 'numeric'
    ];

    private $campos = [
        "nombres",
        "apellidos",
        "id_tipo_documento",
        "nro_doc",
        "provincia",
        "acciones"
    ];

    private $update = [
        'nombres' => 'required|string',
        'apellidos' => 'required|string',
        'id_tipo_documento' => 'required|numeric',
        'id_pais' => 'required_if:id_tipo_documento,5,6',
        'nro_doc' => 'required|numeric',
        'localidad' => 'required|string',
        'id_provincia' => 'required|numeric',
        'id_trabajo' => 'required|numeric',
        'id_genero' => 'required|numeric',
        'id_funcion' => 'required_if:id_trabajo,2,3|numeric',
    //'establecimiento' => 'required_if:id_trabajo,2|required_if:id_trabajo,2|string',
        'id_convenio' => 'nullable',
        'establecimiento1' => 'required_with:id_convenio|string',
        'organismo1' => 'required_if:id_trabajo,3|string',
        'organismo2' => 'required_if:id_trabajo,3|string',
        'email' => 'nullable|email',
        'tel' => 'nullable',
        'cel' => 'nullable'
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
        return view('alumnos', $this->getSelectOptions());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(Alumno::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alumnos/alta', $this->getSelectOptions());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        logger('Quiere crear participante con: '.json_encode($request->all()));
        $v = Validator::make($request->all(), $this->rules);

        if (!$v->fails()) {
            if ($request->has('pais')) {
                $id_pais = Pais::select('id_pais')->where('nombre', $request->pais)->get('id_pais')->first();
                $request->pais = $id_pais;
            }

            if ($request->has('efector')) {
                $con = new EfectoresController();
                $cuie = $con->findCuie($request->efector);
                if ($cuie) {
                    $request->efector = $cuie;
                } else {
                    return response(['error' =>'No existe el efector'], 400);
                }
            }
            $alumno = Alumno::crear($request);
            return response(['data' => $alumno->toArray()], 200);
        } else {
            Log::warning("No se pudo crear el alumno: ".json_encode($v->errors()));
            return response($v->errors(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alumno = Alumno::segunProvincia()
        ->findOrFail($id);

        $id_tipo_documento = $alumno->id_tipo_documento;
        $nombre_pais = null;
        if ($id_tipo_documento === 6 || $id_tipo_documento === 5) {
            $pais = Pais::find($alumno->id_pais);
            $nombre_pais = $pais->nombre;
        }

        return [
            'alumno' => $alumno,
            'pais' => $nombre_pais
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            return view('alumnos/modificar', array_merge($this->show($id), $this->getSelectOptions()));
        } catch (ModelNotFoundException $e) {
            return json_encode('El dato no existe o no tiene permiso para verlo.');
        }
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
        logger('Quiere actualizar participante {$id} con: '.json_encode($request->all()));
        $v = Validator::make($request->all(), $this->update);

        if (!$v->fails()) {
            $a = Alumno::findOrFail($id)->update($request->all());
        } else {
            logger(json_encode($v->errors()));
            return $v->errors();
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
        try {
            Alumno::segunProvincia()
            ->findOrFail($id)
            ->delete();
        } catch (ModelNotFoundException $e) {
            return $e->message;
        }
    }

    /**
     * Devuelve la informacion para abm.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $request['botones']
     * @return \Illuminate\Http\Response
     */
    public function getTabla(Request $r)
    {
        $returns = Alumno::select(
            'id_alumno',
            'nombres',
            'apellidos',
            'nro_doc',
            'alumnos.id_provincia',
            'alumnos.id_tipo_documento'
        )
        ->with(
            [
                'tipoDocumento',
                'provincia'
            ]
        )
        ->segunProvincia();

        return  $this->toDatatable($r, $returns);
    }

    /**
     * Opciones para los selects del front end.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSelectOptions()
    {
        $tipo_documentos = Cache::remember('tipo_documentos', 5, function () {
            return TipoDocumento::all();
        });

        $provincias = Cache::remember('provincias', 5, function () {
            return Provincia::orderBy('nombre')->get();
        });

        $trabajos = Cache::remember('trabajos', 5, function () {
            return Trabajo::orderBy('nombre')->get();
        });

        $funciones = Cache::remember('funciones', 5, function () {
            return Funcion::orderBy('nombre')->get();
        });

        $organismos = Cache::remember('organismos', 5, function () {
            return Alumno::select('organismo1')
            ->where('organismo1', '<>', ' ')
            ->groupBy('organismo1')
            ->orderBy('organismo1')
            ->get();
        });

        $generos = Cache::remember('generos', 5, function () {
            return Genero::all();
        });

        return array(
            'documentos' => $tipo_documentos,
            'provincias' => $provincias,
            'trabajos' => $trabajos,
            'funciones' => $funciones,
            'organismos' => $organismos,
            'generos' => $generos
        );
    }

    /* Metodos Typeahead */

    /**
     * Nombres de organismos para typeahead.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNombreOrganismo()
    {
        return $this->typeahead('organismo2');
    }

    /**
     * Nombres de establecimientos para typeahead.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEstablecimientos(Request $r)
    {
        return $this->typeahead('establecimiento2');
    }

    /**
     * Nombres de los alumnos para el typeahead.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNombres()
    {
        return $this->typeahead('nombres');
    }

    /**
     * Apellidos de los alumnos para el typeahead.
     *
     * @return \Illuminate\Http\Response
     */
    public function getApellidos(Request $r)
    {
        $query = Alumno::select('id_alumno as id', 'nombres', 'apellidos', 'nro_doc as documentos');

        $typed = $r->input('q');
        if (is_numeric($typed)) {
            $query = $query->whereRaw("nro_doc ~* '^{$typed}'");
        } else {
            $nombres = explode(' ', $typed);

            foreach ($nombres as $key => $value) {
                $query = $query->orWhereRaw("nombres ~* '{$value}'")
                ->orWhereRaw("apellidos ~* '{$value}'");
            }
        }

        $matchs = $query
        ->segunProvincia()
        ->get();

        return $this->typeaheadResponse($matchs);
    }

    /**
     * Numero de documento de los alumnos para el typeahead.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDocumentos()
    {
        return $this->typeahead('nro_doc');
    }

    /**
     * Consigue typeahead de la columna.
     *
     * @return \Illuminate\Http\Response
     */
    private function typeahead($columna)
    {
        return $this->typeaheadResponse($this->queryOneColumn($columna));
    }

    /**
     * Consulta una sola columna.
     *
     * @return \Illuminate\Http\Response
     */
    private function queryOneColumn($columna)
    {
        return Alumno::select($columna)
        ->segunProvincia()
        ->groupBy($columna)
        ->orderBy($columna)
        ->get()
        ->map(function ($item, $key) use ($columna) {
            return $item->$columna;
        });
    }

    private function queryLogica(Request $r, $filtros, $order_by)
    {
        $query = Alumno::segunProvincia()
        ->leftJoin(
            'sistema.tipos_documentos',
            'alumnos.id_tipo_documento',
            '=',
            'sistema.tipos_documentos.id_tipo_documento'
        )
        ->leftJoin('sistema.provincias', 'alumnos.id_provincia', '=', 'sistema.provincias.id_provincia')
        ->select(
            'id_alumno',
            'nombres',
            'apellidos',
            'sistema.tipos_documentos.nombre as id_tipo_documento',
            'nro_doc',
            'sistema.provincias.nombre as provincia'
        );

        foreach ($filtros as $key => $value) {
            if ($this->filters[$key] == 'string') {
                $query = $query->whereRaw("alumnos.alumnos.{$key} ~* '{$value}'");
            } else {
                $query = $query->where('alumnos.'.$key, $value);
            }
        }

        return $query;
    }

    public function getFiltrado(Request $r)
    {
        $filtros = collect($r->get('filtros'))
        ->mapWithKeys(function ($item) {
            return [$item['name'] => $item['value']] ;
        })->except(['id_provincia']);


        $order_by = $r->input('order_by', null)?$r->get('order_by'):null;
        
        $v = Validator::make($filtros->all(), $this->filters);
        if (!$v->fails()) {
            $query = $this->queryLogica($r, $filtros, $order_by);
            return $this->toDatatable($r, $query);
        } else {
            return $v->errors();
        }
    }

    /**
     * Devuelve en DataTable los resultados con sus correspondientes acciones.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $request['botones']
     * @param  Collection               $resultados
     * @return \Illuminate\Http\Response
     */
    public function toDatatable(Request $r, $resultados)
    {
        return Datatables::of($resultados)
        ->addColumn(
            'acciones',
            function ($ret) use ($r) {

                $accion = $r->input('botones');

                $editarYEliminar = '<a href="'.url('alumnos').'/'.$ret->id_alumno.'"><button data-id="'.$ret->id_alumno.
                '" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones[0].
                '" aria-hidden="true"></i></button></a>'.'<button data-id="'.$ret->id_alumno.
                '" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="'.$this->botones[1].
                '" aria-hidden="true"></i></button>';

                $agregar = '<button data-id="'.$ret->id_alumno.'" class="btn btn-info btn-xs agregar" '.
                'title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

                return $accion == 'agregar'?$agregar:$editarYEliminar;
            }
        )
        ->make(true);
    }

    /**
     * Corre la query segun filtros y order_by
     * Guarda el resultado en un .xls
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @return string path al archivo generado
     */
    public function getExcel(Request $r)
    {
        $filtros = collect($r->get('filtros'))
        ->mapWithKeys(function ($item) {
            return [$item['name'] => $item['value']] ;
        });

        $order_by = $r->order_by;

        $data = $this->queryLogica($r, $filtros, $order_by)->get();
        $datos = ['alumnos' => $data];
        $path = "participantes_".date("Y-m-d_H:i:s");

        Excel::create(
            $path,
            function ($excel) use ($datos) {
                $excel->sheet(
                    'Participantes',
                    function ($sheet) use ($datos) {
                        $sheet->setHeight(1, 20);
                        $sheet->loadView('excel.alumnos', $datos);
                    }
                );
            }
        )
        ->store('xls');

        return $path;
    }

    /**
     * Corre la query segun filtros y order_by
     * Guarda el resultado en un .pdf
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @return string path al archivo generado
     */
    public function getPdf(Request $r)
    {
        $filtros = collect($r->get('filtros'))
        ->mapWithKeys(function ($item) {
            return [$item['name'] => $item['value']] ;
        });

        $data = $this->queryLogica($r, $filtros, null)->get();

        $header = ['Nombres','Apellidos','Tipo Doc','Nro Doc'];

        if (Auth::user()->id_provincia == 25) {
            array_push($header, 'Provincia');
            $data = $data->map(
                function ($item, $key) {
                    return [
                        $item->nombres,
                        $item->apellidos,
                        $item->id_tipo_documento,
                        $item->nro_doc,
                        $item->provincia,
                    ];
                }
            );
        } else {
            $data = $data->map(
                function ($item, $key) {
                    return [
                        $item->nombres,
                        $item->apellidos,
                        $item->id_tipo_documento,
                        $item->nro_doc,
                    ];
                }
            );
        }

        return $this->toPdf($header,$data);
    }

    private function toPdf($header,$data)
    {
        $column_size = [56,56,20,30,33];
        return Pdf::save($header, $column_size, 13, $data);
    }

    /**
     * Verifica si el numero de documento existe.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkDocumentos(Request $r)
    {
        return [
            'existe' => Alumno::where('nro_doc', $r->input('nro_doc'))
            ->count() != 0
        ];
    }

    public function getExcelCompleto(Request $r, $id)
    {
        $datos = array('participante' => Alumno::findOrFail($id));
        $path = "participante_completo_".date("Y-m-d_H:i:s");
        
        Excel::create($path, function ($excel) use ($datos) {

            $excel->sheet('Participante', function ($sheet) use ($datos) {
                $sheet->setHeight(1, 20);
                $sheet->loadView('excel.participanteCompleto', $datos);
            });

            $excel->sheet('Acciones', function ($sheet) use ($datos) {
                $sheet->setHeight(1, 20);
                $sheet->loadView('excel.acciones', $datos);
            });
        })
        ->store('xls');

        return response()->download(__DIR__."/../../../storage/exports/{$path}.xls");
    }
}
