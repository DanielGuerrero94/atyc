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
use Validation;
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
    'nro_doc' => 'required|numeric|max:8',
    'localidad' => 'required|string',
    'id_provincia' => 'required|numeric',
    'id_trabaja_en' => 'required|numeric',
    'id_funcion' => 'required_if:id_trabaja_en,3,4|numeric',
    'establecimiento' => 'required|string',
    'efector' => 'required|string',
    'tipo_organismo' => 'required|string',
    'nombre_organismo' => 'required|string',
    'email' => 'nullable|email',
    'tel' => 'nullable',
    'cel' => 'nullable'
    ];

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

    public function getAlumnosTabla()
    {
        //Me trae todas las columnas
        /*$query = "SELECT A.id,nombres,apellidos,tipo_doc,nro_doc,P.descripcion as \"provincia\" FROM alumnos A INNER JOIN provincias P ON P.id = provincia";
        $returns = $this->query($query);*/

        $returns = Alumno::select('id_alumno','nombres','apellidos','nro_doc','id_provincia','id_tipo_documento')
        ->with([
            'tipo_documento',
            'provincia'
        ]);        

        if(Auth::user()->id_provincia == 25){           
            $id_provincia = Auth::user()->id_provincia;
            $returns = $returns->where('alumnos.alumnos.id_provincia',$id_provincia);
        }

        $returns = collect($returns->get());

        //Tengo que pasarle una coleccion no un array al datatables
        return Datatables::of($returns)
        ->addColumn('action' , function($ret){
            return '<button alumno-id="'.$ret->id_alumno.'" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones[0].'" aria-hidden="true"></i></button>'.'<button alumno-id="'.$ret->id_alumno.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="'.$this->botones[1].'" aria-hidden="true"></i></button>';
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
        /*$query = "SELECT * FROM alumnos WHERE id = ".$id;
        $returns = $this->query($query);*/

        $alumno = Alumno::find($id);
        $id_tipo_doc = $alumno->id_tipo_doc;
        $nombre_pais = null;
        if($id_tipo_doc === 6 || $id_tipo_doc === 5){
            $pais = Pais::find($alumno->id_pais);    
            $nombre_pais = $pais->nombre;
        }
        $array = array('alumno' => $alumno,'pais' => $nombre_pais);
        $ret = array_merge($array,$this->getSelectOptions());
        return view('alumnos/modificar',$ret);
    }

    public function set(Request $r)
    {
        $v = Validator::make('',$this->_rules);

        Log::info(json_encode($r->establecimiento));
        Log::info(json_encode($r->efectores));
        Log::info(json_encode($r->organismo));
        if($r->has('pais')){
            $r->pais = Pais::select('id')->where('nombre','=',$r->pais)->get('id')->first(); 
            $r->pais = $r->pais['id'];    
        }
        $alumno = Alumno::crear($r);
        Log::info(json_encode($alumno));
    }    

    public function borrar(Request $r,$id)
    {
        $alumno = Alumno::find($id);
        $alumno->delete();
        Log::info('Se da de baja el alumno con id:'.$id);
    }

    public function datosJoineados()
    {        
        /*$alumnos = Alumno::with([
            'provincia',
            'tipo_doc'
            ])->get();

            return json_encode($alumnos);*/

            $alumnos = DB::table('alumnos')
            ->leftJoin('provincias','alumnos.id_provincia','=','provincias.id')
            ->leftJoin('tipo_docs','alumnos.id_tipo_doc','=','tipo_docs.id')
            ->leftJoin('trabajas','alumnos.id_trabaja_en','=','trabajas.id')
            ->leftJoin('funcions','alumnos.id_funcion','=','funcions.id')
            ->select(
                'alumnos.*',
                'provincias.nombre as provincia',
                'tipo_docs.nombre as tipo_docs',
                'tipo_docs.titulo as tipo_docs_titulo',
                'trabajas.nombre as trabajas',
                'funcions.nombre as funcions')
            ->get();
            return json_encode($alumnos);

        /*$alumnoConProvincia = Alumno::chunk('10',function ($alumnos){
                foreach ($alumnos as $alumno) {
                        $alumno->provincia;
                        $alumno->tipo_doc;
                        $alumno->trabaja_en;
                        $alumno->funcion;
                        echo json_encode($alumno);             
                      }      
                  });*/
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

    //Metodos para typeahead

    public function getNombreOrganismo()
    {
        $nombresOrganismos = Alumno::select('organismo2')->groupBy('organismo2')->orderBy('organismo2')->get();

        $arrayMapeado = collect($nombresOrganismos)->map(function($item,$key)
        {
            return $item->organismo2;
        });

        $ret = array(
            'status' => true,
            'error' => null,
            'data' => array(
                'info' => $arrayMapeado
                )
            );

        return json_encode($ret);
    }

    public function getEstablecimientos()
    {
        $establecimiento = Alumno::select('establecimiento2')->groupBy('establecimiento2')->orderBy('establecimiento2')->get();

        $arrayMapeado = collect($establecimiento)->map(function($item,$key)
        {
            return $item->establecimiento2;
        });

        $ret = array(
            'status' => true,
            'error' => null,
            'data' => array(
                'info' => $arrayMapeado
                )
            );

        return json_encode($ret);
    }

    /*public function ejemploPdf($)
    {
        $data = [
            'lotes' => $lotes,
            'nombre_padron' => $this->getNombrePadron($padron),
            'padron' => $padron,            
            'resumen' => $resumen,
            'jurisdiccion' => Provincia::where('id_provincia' , Auth::user()->id_provincia)->firstOrFail(),
            'ddjj' => DDJJSirge::findOrFail($id)
        ];

        $pdf = PDF::loadView('pdf.ddjj.sirge' , $data);     
        return $pdf->download("ddjj-sirge-$id.pdf");
    }*/

    public function checkDocumentos($documento)
    {
        $ret = Alumno::where('nro_doc','=',$documento)
        ->get();
        return count($ret) != 0?'true':'false';
    }
}
