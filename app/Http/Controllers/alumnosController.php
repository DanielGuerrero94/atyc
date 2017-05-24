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

class alumnosController extends Controller 
{
    private 
    $_rules = [
    'nombres' => 'required|string',
    'apellidos' => 'required|string',
    'id_tipo_doc' => 'required|numeric',
    'pais' => 'required_if:id_tipo_doc,5,6',
    'nro_doc' => 'required|numeric',
    'localidad' => 'required|string',
    'id_provincia' => 'required|numeric',
    'id_trabaja_en' => 'required|numeric',
    'id_funcion' => 'required_if:id_trabaja_en,2,3|numeric',
    'establecimiento' => 'required_if:id_trabaja_en,2|string',
    'efector' => 'required_if:id_trabaja_en,2|string',
    'tipo_organismo' => 'required_if:id_trabaja_en,3|string',
    'nombre_organismo' => 'required_if:id_trabaja_en,3|string',
    'email' => 'nullable|email',
    'tel' => 'nullable',
    'cel' => 'nullable'
    ];

    private 
    $_filters = [
    'nombres' => 'string',
    'apellidos' => 'string',
    'id_tipo_doc' => 'numeric',
    'id_provincia' => 'numeric',
    'cel' => 'string',
    'tel' => 'string',
    'email' => 'string',//Tiene que ser string porque si en el filtro no quieren ponerlo completo yo lo comparo con un ilike
    'localidad' => 'string',
    'nro_doc' => 'numeric'];

    private $campos = ["nombres","apellidos","tipo_doc","nro_doc","provincia","acciones"];
    private $botones = ['fa fa-pencil-square-o','fa fa-trash-o'];

    public function query($query)
    {
        return DB::connection('eLearning')->select($query);
    }	

    public function get()
    {
    	return view('alumnos',$this->getSelectOptions());
    }

    public function getJoined()
    {
    	$query = "SELECT * FROM alumnos A INNER JOIN provincias P ON A.provincia = P.id";
    	$ret =  $this->query($query);
        return view('alumnos',['alumnos' => json_encode($ret)]);   
    }    

    public function getTabla(Request $r)
    {
        $returns = Alumno::select('id_alumno','nombres','apellidos','nro_doc','id_provincia','id_tipo_documento')
        ->with([
            'tipo_documento',
            'provincia'                                       
        ]);     

        if(Auth::user()->id_provincia != 25){           
            $returns = $returns->where('id_provincia',Auth::user()->id_provincia);
        }

        $returns = collect($returns->get());

         //Tengo que pasarle una coleccion                                                                                                                                                                                                                                      no un array al datatables
        return Datatables::of($returns)
        ->addColumn('acciones' , function($ret) use($r){

            $accion = $r->has('botones')?$r->botones:null;

            $editarYEliminar = '<a href="'.url('alumnos').'/'.$ret->id_alumno.'"><button alumno-id="'.$ret->id_alumno.'" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones[0].'" aria-hidden="true"></i></button></a>'.'<button alumno-id="'.$ret->id_alumno.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="'.$this->botones[1].'" aria-hidden="true"></i></button>';

            $agregar = '<button profesor-id="'.$ret->id_alumno.'" class="btn btn-info btn-xs agregar" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

            $botones = $editarYEliminar;

            if($accion == 'agregar'){
                $botones = $agregar;
            }           
            return $botones;
        })            
        ->make(true); 
    }

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

    public function getAlta()
    {
        return view('alumnos/alta',$this->getSelectOptions());
    }

    public function getActivos()
    {
        $query = "SELECT count(*) as activos FROM g_plannacer.alumnos A INNER JOIN g_plannacer.cursos_alumnos CA ON CA.alumno = A.id WHERE EXTRACT(YEAR FROM CA.fecha_acreditacion) = EXTRACT(YEAR FROM CURRENT_DATE)";
        $returns = $this->query($query);
        $returns = collect($returns)->first();
        return json_encode($returns);
    }

    public function getData($id)
    {
        $alumno = Alumno::find($id);
        $id_tipo_documento = $alumno->id_tipo_documento;
        $nombre_pais = null;
        if($id_tipo_documento === 6 || $id_tipo_documento === 5){
            $pais = Pais::find($alumno->id_pais);    
            $nombre_pais = $pais->nombre;
        }
        $array = array('alumno' => $alumno,'pais' => $nombre_pais);
        $ret = array_merge($array,$this->getSelectOptions());
        return view('alumnos/modificar',$ret);
    }

    public function set(Request $r)
    {
        $v = Validator::make($r->all(),$this->_rules);

        if(!$v->fails()){
            if($r->has('pais')){
                $r->pais = Pais::select('id')->where('nombre','=',$r->pais)->get('id')->first(); 
                $r->pais = $r->pais['id'];    
            }
            $alumno = Alumno::crear($r);
        }else{
            return json_encode($v->errors());
        }
    }    

    public function borrar(Request $r,$id)
    {
        $alumno = Alumno::find($id);
        $alumno->delete();
        Log::info(Auth::ip());
        Log::info('Se da de baja el alumno con id:'.$id);
    }

    public function modificar(Request $r,$id)
    {
        $alumno = Alumno::find($id);
        $alumno->modificar();
    } 

            /*funciones para typeahead*/    

            /*para tener de ejemplo*/
    /*public function getNombres()
    {   
        $nombres = Curso::select('nombre')->groupBy('nombre')->orderBy('nombre')->get();
        $nombres = collect($nombres);

        $arrayMapeado = $nombres->map(function($item,$key)
        {
            return $item->nombre;
        });

        $ret = array(
            'status' => true,
            'error' => null,
            'data' => array(
                'info' => $arrayMapeado
                )
            );

        return json_encode($ret);
    }*/

    /* Metodos Typeahead */

    public function getNombreOrganismo()
    {
        $organismos = Alumno::select('organismo2')
        ->groupBy('organismo2')
        ->orderBy('organismo2')
        ->get()
        ->map(function($item,$key){
            return $item->organismo2;
        });

        $ret = array(
            'status' => true,
            'error' => null,
            'data' => array(
                'info' => $organismos
                )
            );

        return json_encode($ret);
    }

    public function getEstablecimientos()
    {
        $establecimientos = Alumno::select('establecimiento2')
        ->groupBy('establecimiento2')
        ->orderBy('establecimiento2')
        ->get()
        ->map(function($item,$key){
            return $item->establecimiento2;
        });

        $ret = array(
            'status' => true,
            'error' => null,
            'data' => array(
                'info' => $establecimientos
                )
            );

        return json_encode($ret);
    }
    /* Metodos Typeahead */

    private function queryLogica(Request $r,$filtros,$order_by)
    {
        //Filtros las que estan vacias si es que me las pasaron
        //Estas funciones para filtrar podrian estar en un middleware
        $filtered = $filtros->filter(function ($value,$key)
        {
            return $value != "" && $value != "0";
        });

        $returns = DB::table('alumnos.alumnos');

        $provincia = Auth::user()->id_provincia;
        //Con esto logro que las provincias solo vean lo que les corresponda pero la uec tenga disponible los filtros 
        if ($provincia != 25) {
            $returns = $returns->where('alumnos.alumnos..id_provincia','=',$provincia);
        }

        foreach ($filtered as $key => $value) {

            if($key == 'nombres' || $key == 'apellidos' || $key == 'localidad' || $key == 'email'){
                $returns = $returns->where('alumnos.alumnos.'.$key,'ilike','%'.$value.'%');                           
            }elseif($key == 'tipo_doc'){
                $returns = $returns->where('alumnos.alumnos.id_tipo_documento =',$value);                           
            }else{
                $returns = $returns->where('alumnos.alumnos.'.$key,'=',$value);                           
            }
        }

        $returns = $returns
        ->leftJoin('sistema.provincias','alumnos.alumnos.id_provincia','=','sistema.provincias.id_provincia')
        ->leftJoin('sistema.tipos_documentos','alumnos.alumnos.id_tipo_documento','=','sistema.tipos_documentos.id_tipo_documento')
        ->select(
            'alumnos.alumnos.id_alumno','alumnos.alumnos.nombres','alumnos.alumnos.apellidos',
            'sistema.tipos_documentos.nombre as tipo_doc',
            'alumnos.alumnos.nro_doc',
            'sistema.provincias.nombre as provincia')
        ->whereNull('alumnos.alumnos.deleted_at');

        $returns = $returns
        ->orderBy($order_by);

        return collect($returns->get());
    }

    public function getFiltrado(Request $r){
        $filtros = collect($r->only('filtros'));
        $filtros = collect($filtros->get('filtros'));

        $order_by = $r->has('order_by')?$r->get('order_by'):null;

        $v = Validator::make($filtros->all(),$this->_filters);
        if(!$v->fails()){

            $aux = $this->queryLogica($r,$filtros,$order_by);  

            $tabla = Datatables::of($aux)
            ->addColumn('acciones' , function($ret) use ($r){

                $accion = $r->has('botones')?$r->botones:null;

                $editarYEliminar = '<a href="'.url('alumnos').'/'.$ret->id_alumno.'"><button data-id="'.$ret->id_alumno.'" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones[0].'" aria-hidden="true"></i></button></a>'.'<button data-id="'.$ret->id_alumno.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="'.$this->botones[1].'" aria-hidden="true"></i></button>';

                $agregar = '<button data-id="'.$ret->id_alumno.'" class="btn btn-info btn-xs agregar" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';
                
                return $accion == 'agregar'?$agregar:$editarYEliminar;;
            })            
            ->make(true);

            return $tabla;
        }else{
            return json_encode($v->errors());
        }   
    }

    public function getExcel(Request $r)
    {       
        $filtros = collect($r->only('filtros'));
        $filtros = collect($filtros->get('filtros'));
        $order_by = $r->order_by;

        $data = $this->queryLogica($r,$filtros,$order_by);
        $datos = ['alumnos' => $data];
        $path = "alumnos_filtrados_".date("Y-m-d_H:i:s");
        

        Excel::create($path, function ($excel) use ($datos){
            $excel->sheet('Reporte', function ($sheet) use ($datos){
                $sheet->setHeight(1, 20);
                $sheet->loadView('excel.alumnos', $datos);
            });
        })
        ->store('xls');

        return $path;
    }

    public function getPdf(Request $r)
    {
        $filtros = collect($r->only('filtros'));
        $filtros = collect($filtros->get('filtros'));

        $data = $this->queryLogica($r,$filtros);
        /*$datos = ['alumnos' => $data];
        $path = "alumnos_filtrados_".date("Y-m-d_H:i:s");

        $pdf = PDF::loadView('excel.alumnos',$datos)->save($path.".pdf");*/

        $header = array('Nombres','Apellidos','Tipo Doc','Nro Doc','Provincia');
        $column_size = array(56,56,20,30,33);

        $mapped = $data->map(function ($item,$key){
                $alumno = array();
                array_push($alumno, $item->nombres);
                array_push($alumno, $item->apellidos);
                array_push($alumno, $item->tipo_doc);
                array_push($alumno, $item->nro_doc);
                array_push($alumno, $item->provincia);
                return $alumno;
            });

        return PDF::save($header,$column_size,13,$mapped);
    }

    public function checkDocumentos($documento)
    {
        $ret = Alumno::where('nro_doc','=',$documento)
        ->get();
        return count($ret) != 0?'true':'false';
    }
}
