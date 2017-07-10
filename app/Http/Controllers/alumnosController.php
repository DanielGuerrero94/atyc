<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provincia;
use App\Pais;
use App\Funcion;
use App\Trabajo;
use App\TipoDocumento;
use App\Alumno;
use Auth;
use DB;
use Validator;
use Datatables;
use Log;
use Excel;
use App\PDF as Pdf;

class alumnosController extends AbmController
{
    private 
    $_rules = [
    'nombres' => 'required|string',
    'apellidos' => 'required|string',
    'id_tipo_documento' => 'required|numeric',
    'pais' => 'required_if:id_tipo_documento,5,6',
    'nro_doc' => 'required|numeric',
    'localidad' => 'required|string',
    'id_provincia' => 'required|numeric',
    'id_trabajo' => 'required|numeric',
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

    private 
    $_filters = [
    'nombres' => 'string',
    'apellidos' => 'string',
    'id_tipo_documento' => 'numeric',
    'id_provincia' => 'numeric',
    'cel' => 'string',
    'tel' => 'string',
    'email' => 'string',//Tiene que ser string porque si en el filtro no quieren ponerlo completo yo lo comparo con un ilike
    'localidad' => 'string',
    'nro_doc' => 'numeric'];

    private $_campos = ["nombres","apellidos","tipo_documento","nro_doc","provincia","acciones"];
    private $_botones = ['fa fa-pencil-square-o','fa fa-trash-o'];

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
        $v = Validator::make($request->all(), $this->_rules);

        if (!$v->fails()) {
            if ($request->has('pais')) {
                $request->pais = Pais::select('id_pais')->where('nombre', '=', $request->pais)->get('id_pais')->first(); 
                $request->pais = $request->pais['id_pais'];    
            }
            return Alumno::crear($request);
        } else {
            logger(json_encode($v->errors()));
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
        $alumno = Alumno::findOrFail($id);
        $id_tipo_documento = $alumno->id_tipo_documento;
        $nombre_pais = null;
        if ($id_tipo_documento === 6 || $id_tipo_documento === 5) {
            $pais = Pais::find($alumno->id_pais);    
            $nombre_pais = $pais->nombre;
        }
        $array = array('alumno' => $alumno,'pais' => $nombre_pais);
        return array_merge($array, $this->getSelectOptions());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('alumnos/modificar', $this->show($id));
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
        return Alumno::findOrFail($id)->modificar($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Alumno::findOrFail($id)->delete();
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
        $returns = Alumno::select('id_alumno', 'nombres', 'apellidos', 'nro_doc', 'id_provincia', 'id_tipo_documento')
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
        $documentos = TipoDocumento::all();        
        $provincias = Provincia::orderBy('nombre')->get();
        $trabajos = Trabajo::orderBy('nombre')->get();
        $funciones = Funcion::orderBy('nombre')->get();        
        $organismos = Alumno::select('organismo1')->groupBy('organismo1')->orderBy('organismo1')->get();

        return array(
            'documentos' => $documentos,
            'provincias' => $provincias,
            'trabajos' => $trabajos,
            'funciones' => $funciones,
            'organismos' => $organismos);
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
    public function getEstablecimientos()
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
    public function getApellidos()
    {
        $alumno = Alumno::select('id_alumno', 'nombres', 'apellidos', 'nro_doc')
        ->segunProvincia()
        ->get()
        ->map(
            function ($item,$key) {
                return array('id' => $item->id_alumno,'nombres' => $item->nombres,'apellidos' => $item->apellidos,'documentos' => $item->nro_doc);
            }
        );
        return $this->typeaheadResponse($alumno);
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
        ->map(
            function ($item,$key) use ($columna) {
                return $item->$columna;
            }
        );
    }
    
    /* Metodos Typeahead */

    private function queryLogica(Request $r,$filtros,$order_by)
    {
        //Filtros las que estan vacias si es que me las pasaron
        //Estas funciones para filtrar podrian estar en un middleware
        $filtered = $filtros->filter(
            function ($value,$key) {
                return $value != "" && $value != "0";
            }
        );

        $query = Alumno::leftJoin('sistema.provincias', 'alumnos.id_provincia', '=', 'sistema.provincias.id_provincia')
        ->leftJoin('sistema.tipos_documentos', 'alumnos.id_tipo_documento', '=', 'sistema.tipos_documentos.id_tipo_documento')
        ->select(
            'id_alumno', 'nombres', 'apellidos',
            'sistema.tipos_documentos.nombre as id_tipo_documento',
            'nro_doc',
            'sistema.provincias.nombre as provincia'
        );

        //Con esto logro que las provincias solo vean lo que les corresponda pero la uec tenga disponible los filtros 
        if (Auth::user()->id_provincia != 25) {
            $query = $query->where('alumnos.alumnos.id_provincia', '=', Auth::user()->id_provincia);
        }

        foreach ($filtered as $key => $value) {

            if($key == 'nombres' || $key == 'apellidos' || $key == 'localidad' || $key == 'email') {
                $query = $query->where('alumnos.alumnos.'.$key, 'ilike', '%'.$value.'%');                           
            }elseif($key == 'id_tipo_documento') {
                $query = $query->where('alumnos.id_tipo_documento', $value);                           
            }else{
                $query = $query->where('alumnos.'.$key, $value);                           
            }
        }

        return $query;
    }

    public function getFiltrado(Request $r)
    {
        $filtros = collect($r->only('filtros'));
        $filtros = collect($filtros->get('filtros'));

        $order_by = $r->has('order_by')?$r->get('order_by'):null;

        $v = Validator::make($filtros->all(), $this->_filters);
        if (!$v->fails()) {

            $query = $this->queryLogica($r, $filtros, $order_by);             

            return $this->toDatatable($r, $query);
        } else {
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
    public function toDatatable(Request $r,$resultados)
    {
        return Datatables::of($resultados)
        ->addColumn(
            'acciones', function ($ret) use ($r) {

                $accion = $r->has('botones')?$r->botones:null;

                $editarYEliminar = '<a href="'.url('alumnos').'/'.$ret->id_alumno.'"><button data-id="'.$ret->id_alumno.'" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones[0].'" aria-hidden="true"></i></button></a>'.'<button data-id="'.$ret->id_alumno.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="'.$this->botones[1].'" aria-hidden="true"></i></button>';

                $agregar = '<button data-id="'.$ret->id_alumno.'" class="btn btn-info btn-xs agregar" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

                return $accion == 'agregar'?$agregar:$editarYEliminar;;
            }
        )            
        ->make(true);
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
        $order_by = $r->order_by;

        $data = $this->queryLogica($r, $filtros, $order_by);
        $datos = ['alumnos' => $data];
        $path = "alumnos_filtrados_".date("Y-m-d_H:i:s");
        

        Excel::create(
            $path, function ($excel) use ($datos) {
                $excel->sheet(
                    'Reporte', function ($sheet) use ($datos) {
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
     * @param  array filtros
     * @param  array order_by
     * @return \Illuminate\Http\Response
     * @return string path al archivo generado
     */
    public function getPdf(Request $r)
    {
        $filtros = collect($r->only('filtros'));
        $filtros = collect($filtros->get('filtros'));

        $data = $this->queryLogica($r, $filtros, null)->get();

        $header = array('Nombres','Apellidos','Tipo Doc','Nro Doc','Provincia');
        $column_size = array(56,56,20,30,33);

        $mapped = $data->map(
            function ($item,$key) {
                $alumno = array();
                array_push($alumno, $item->nombres);
                array_push($alumno, $item->apellidos);
                array_push($alumno, $item->id_tipo_documento);
                array_push($alumno, $item->nro_doc);
                array_push($alumno, $item->provincia);
                return $alumno;
            }
        );

        return Pdf::save($header, $column_size, 13, $mapped);
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
            Alumno::where('nro_doc', $documento)
                ->get()->count() != 0
        );
    }
}
