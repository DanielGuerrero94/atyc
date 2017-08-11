<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\TipoDocente;
use App\TipoDocumento;
use App\Profesor;
use App\Pais;
use Cache;
use DB;
use Auth;
use Log;
use Validator;
use Datatables;
use Excel;
use App\PDF as Pdf;

class ProfesoresController extends AbmController
{

    private $rules = [
    'nombres' => 'required|string',
    'apellidos' => 'required|string',
    'id_tipo_documento' => 'required|numeric',
    'id_tipo_docente' => 'required|numeric',
    'pais' => 'required_if:id_tipo_documento,5,6',
    'nro_doc' => 'required|numeric',
    'email' => 'nullable|email',
    'tel' => 'nullable|numeric',
    'cel' => 'nullable|numeric'
    ],
    $filters = [
    'nombres' => 'string',
    'apellidos' => 'string',
    'id_tipo_documento' => 'numeric',
    'id_tipo_docente' => 'numeric',
    'cel' => 'string',
    'tel' => 'string',//11
    'email' => 'string',//Tiene que ser string porque si en el filtro no quieren ponerlo completo yo lo comparo con un ilike
    'nro_doc' => 'numeric'
    ],
    $botones = [
    'fa fa-pencil-square-o',
    'fa fa-trash-o'
    ];

    public function query($query)
    {
        return DB::connection('eLearning')->select($query);
    }

    /**
    * View para abm.
    *
    * @return \Illuminate\Http\Response
    */
    public function get()
    {
        return view('profesores', $this->getSelectOptions());
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return json_encode(Profesor::all());
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('profesores/alta', $this->getSelectOptions());
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), $this->rules);
        
        if (!$v->fails()) {
            $profesor = new Profesor();
            return $profesor->crear($request);
        } else {
            return json_encode(
                array(
                    'status' => false,
                    'error' => $v->errors()
                    )
                );
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
        try {
            $profesor = Profesor::with(['tipoDocente'])->findOrFail($id);
            $nombre_pais = null;
            $id_tipo_documento = $profesor->id_tipo_documento;
            if ($id_tipo_documento === 6 || $id_tipo_documento === 5) {
                $pais = Pais::find($profesor->id_pais);
                $nombre_pais = $pais->nombre;
            }
            $profesor = array('profesor' => $profesor,'pais' => $nombre_pais);
            return array_merge($profesor, $this->getSelectOptions());            
        } catch (ModelNotFoundException $e) {
            return json_encode($e->message);
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
        return view('profesores/modificar', $this->show($id));
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
                logger(json_encode($request->all()));
                try {
                    $profesor = Profesor::findOrFail($id);            
                    if ($request->id_tipo_doc === '6' || $request->id_tipo_doc === '5') {
                        $request->pais = Pais::select('id')->where('nombre', '=', $request->pais)->get('id')->first();
                        $request->pais = $request->pais['id'];
                    }
                    return $profesor->modificar($request);
                } catch (ModelNotFoundException $e) {
                    return json_encode($e->message);
                }        
            }

                /*ebsas1
                1234
                sistemasuec 
                $uMaR2017*/

                /**
                * Remove the specified resource from storage.
                *
                * @param  int $id
                * @return \Illuminate\Http\Response
                */
                public function destroy($id)
                {
                    logger($id);
                    try {
                        return Profesor::findOrFail($id)->delete();
                    } catch (ModelNotFoundException $e) {
                        return json_encode($e->message());
                    }
                }

                    /**
                    * Devuelve la informacion para abm.
                    *
                    * @return \Illuminate\Http\Response
                    */
                    public function getTabla(Request $r)
                    {
                        $query = Profesor::select('id_profesor', 'nombres', 'apellidos', 'nro_doc', 'id_tipo_documento')
                        ->with('tipoDocumento');

                        return $this->toDatatable($r, $query);
                    }

                    private function queryLogica(Request $r, $filtros)
                    {
                        //Filtros las que estan vacias si es que me las pasaron
                        $filtered = $filtros->filter(
                            function ($value, $key) {
                                return $value != "";
                            }
                            );

                        //Otra forma puedo ir agregando clausulas where
                        $query = Profesor::leftJoin('sistema.tipos_documentos', 'sistema.profesores.id_tipo_documento', '=', 'sistema.tipos_documentos.id_tipo_documento')
                        ->select(
                            'sistema.profesores.id_profesor',
                            'sistema.profesores.nombres',
                            'sistema.profesores.apellidos',
                            'sistema.tipos_documentos.nombre as tipo_doc',
                            'sistema.profesores.nro_doc'
                            );

                        foreach ($filtered as $key => $value) {
                            if ($key == 'nombres' || $key == 'apellidos' || $key == 'email') {
                                $query = $query->where('sistema.profesores.'.$key, 'ilike', $value.'%');
                            } else {
                                $query = $query->where('sistema.profesores.'.$key, '=', $value);
                            }
                        }

                        return $query;
                    }

                    public function getFiltrado(Request $r)
                    {
                        $filtros = collect($r->only('filtros'));

                        $filtros = collect($filtros->get('filtros'));



                            //Tengo que crear un metodo lo suficientemente generico como para poder ponerlo en abmcontroller
                            //Hago un test solo por nombre para armar el front end
                        $v = Validator::make($filtros->all(), $this->filters);
                        if (!$v->fails()) {
                            $query = $this->queryLogica($r, $filtros);

                            return $this->toDatatable($r, $query);
                        } else {
                            logger('No paso');
                            logger($v->errors());
                            return json_encode($v->errors());
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

                                        $accion = $r->has('botones')?$r->botones:null;

                                        $editarYEliminar = '<a href="'.url('profesores').'/'.$ret->id_profesor.'"><button data-id="'.$ret->id_profesor.'" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones[0].'" aria-hidden="true"></i></button></a>'.'<button data-id="'.$ret->id_profesor.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="'.$this->botones[1].'" aria-hidden="true"></i></button>';

                                        $agregar = '<button data-id="'.$ret->id_profesor.'" class="btn btn-info btn-xs agregar" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

                                        return $accion == 'agregar'?$agregar:$editarYEliminar;
                                    }
                                    )
                                ->make(true);
                            }

                            /**
                            * Opciones para los selects del front end.
                            *
                            * @return \Illuminate\Http\Response
                            */
                            public function getSelectOptions()
                            {
                                $tipoDocumentos = Cache::remember('tipo_documentos', 5, function () {
                                    return TipoDocumento::all();
                                });

                                $tipoDocentes = Cache::remember('tipo_docentes', 5, function () {
                                    return TipoDocente::all();
                                });

                                return array(
                                    'tipoDocumento' => $tipoDocumentos,
                                    'tipoDocente' => $tipoDocentes
                                    );
                            }

                            /**
                            * Apellidos de los profesores para el typeahead.
                            *
                            * @return \Illuminate\Http\Response
                            */
                            public function getTypeahead(Request $r)
                            {
                                $profesor = Profesor::select('id_profesor', 'nombres', 'apellidos', 'nro_doc')
                                ->get()
                                ->map(
                                    function ($item, $key) {
                                        return array('id' => $item->id_profesor,'nombres' => $item->nombres,'apellidos' => $item->apellidos,'documentos' => $item->nro_doc);
                                    }
                                    );
                                return $this->typeaheadResponse($profesor);
                            }

                            /**
                            * Corre la query segun filtros y order_by
                            * Guarda el resultado en un .xls
                            *
                            * @param  \Illuminate\Http\Request $request
                            * @param  array filtros
                            * @param  array order_by
                            * @return \Illuminate\Http\Response
                            * @return string path al archivo generado
                            */
                            public function getExcel(Request $r)
                            {
                                $filtros = collect($r->only('filtros'));
                                $filtros = collect($filtros->get('filtros'));

                                $data = $this->queryLogica($r, $filtros)->get();
                                $datos = ['profesores' => $data];
                                $path = "docentes_".date("Y-m-d_H:i:s");

                                Excel::create(
                                    $path,
                                    function ($excel) use ($datos) {
                                        $excel->sheet(
                                            'Reporte',
                                            function ($sheet) use ($datos) {
                                                $sheet->setHeight(1, 20);
                                                $sheet->loadView('excel.profesores', $datos);
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
                            * @param  array filtros
                            * @param  array order_by
                            * @return \Illuminate\Http\Response
                            * @return string path al archivo generado
                            */
                            public function getPDF(Request $r)
                            {
                                $filtros = collect($r->only('filtros'));
                                $filtros = collect($filtros->get('filtros'));

                                $data = $this->queryLogica($r, $filtros)->get();
                                $header = array('Nombres','Apellidos','Tipo doc','Nro doc');
                                $column_size = array(65, 65, 25, 35);

                                $mapped = $data->map(
                                    function ($item, $key) {
                                        $profesor = array();
                                        array_push($profesor, $item->nombres);
                                        array_push($profesor, $item->apellidos);
                                        array_push($profesor, $item->tipo_doc);
                                        array_push($profesor, $item->nro_doc);
                                        return $profesor;
                                    }
                                    );

                                return Pdf::save($header, $column_size, 14, $mapped);
                            }

                            /**
                            * Verifica si el numero de documento existe.
                            *
                            * @param  string $documento
                            * @return \Illuminate\Http\Response
                            */
                            public function checkDocumentos($documento)
                            {
                                return json_encode(
                                    Profesor::where('nro_doc', $documento)
                                    ->get()->count() != 0
                                    );
                            }
                        }
