<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\TipoDocumento;
use App\Profesor;
use App\Pais;
use Validator;
use DB;
use Log;
use Datatables;

class profesoresController extends Controller
{
    private 
    $_rules = [
    'nombres' => 'required|string',
    'apellidos' => 'required|string',
    'id_tipo_doc' => 'required|numeric',
    'pais' => 'required_if:id_tipo_doc,5,6',
    'nro_doc' => 'required|numeric',
    'email' => 'nullable|email',
    'tel' => 'nullable',
    'cel' => 'nullable'
    ];

    private 
    $_filters = [
    'nombres' => 'string',
    'apellidos' => 'string',
    'id_tipo_doc' => 'numeric',
    'id_pais' => 'numeric',
    'nro_doc' => 'numeric'];

    public function query($query)
    {
    	return DB::connection('eLearning')->select($query);
    }

    public function get()
    {/*
    	$query = "SELECT * FROM profesores";
    	$ret = $this->query($query);
    	return view('profesores',['profesores' => json_encode($ret)]);*/
        return view('profesores');
    }    

    public function getProfesoresTabla()
    {
        /*$returns = DB::table('sistema.profesores')
        ->leftJoin('sistema.tipos_documentos','sistema.profesores.id_tipo_documento','=','sistema.tipos_documentos.id_tipo_documento')
        ->select(
            'sistema.profesores.id_profesor','sistema.profesores.nombres','sistema.profesores.apellidos',
            'sistema.tipos_documentos.nombre as tipo_doc',
            'sistema.profesores.nro_doc')
        ->whereNull('sistema.profesores.deleted_at')
        ->get();*/

        $returns = Profesor::select(

        )->with([
            'tipo_documento'
        ])->get();

        $returns = collect($returns);
        
        return Datatables::of($returns)
        ->addColumn('acciones' , function($ret){
            $accion = Input::get('botones');

            $editarYEliminar = '<button data-id="'.$ret->id_profesor.'" class="btn btn-info btn-xs editar" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'.'<button data-id="'.$ret->id_profesor.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';

            $agregar = '<button profesor-id="'.$ret->id_profesor.'" class="btn btn-info btn-xs agregar" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

            $botones = $editarYEliminar;

            if($accion == 'agregar'){
                $botones = $agregar;
            }           
            return $botones;
        })            
        ->make(true); 
    }

    public function getAlta()
    {
        return view('profesores/alta',$this->getSelectOptions());
    }

    public function getFiltrado(Request $r)
    {
        //Tengo que crear un metodo lo suficientemente generico como para poder ponerlo en abmcontroller
        //Hago un test solo por nombre para armar el front end
        $v = Validator::make($r->all(),$this->_filters);
        if(!$v->fails()){

            $ret = collect($r->all());

            Log::info("Antes:".json_encode($ret));

            $filtered = $ret->filter(function ($key,$value)
            {
                return $key != "";
            });

            $mapped = $filtered->map(function ($value,$key)
            {
                Log::info(json_encode($value));   
                Log::info(json_encode($key));
                $key = mb_strtolower($key);
                Log::info(json_encode($key));
                return $value;   
            });

            /*$reduced = $ret->reduce(function ($reduced,$ret)
            {  
                foreach ($ret as $key => $value) {
                    $reduced[mb_strtolower($key)] = $value;    
                }
                Log::info(json_encode($reduced));
                return $reduced;   
            },[]);*/

            //Una forma es agregarle le where crudo con DB:raw
            /*$reduced = "";
            foreach ($filtered as $key => $value) {
                
                    $reduced .= mb_strtolower($key)." LIKE '%".$value."%'";          
            }
            Log::info("Para el where: ".json_encode(DB::raw($reduced)));

            $returns = DB::table('profesores')
            ->where(DB::raw($reduced))
            ->leftJoin('tipo_docs','profesores.id_tipo_doc','=','tipo_docs.id')
            ->select(
                'profesores.id','profesores.nombres','profesores.apellidos',
                'tipo_docs.nombre as tipo_doc',
                'profesores.nro_doc')
            ->whereNull('profesores.deleted_at')
            ->get();

            Log::info('Datos para la nueva table: '.json_encode($returns));    */

            //Otra forma puedo ir agregando clausulas where
            $returns = DB::table('profesores');
            /*foreach ($filtered as $key => $value) {

                $returns->where(mb_strtolower($key),'LIKE',"'%".$value."%'");          
            }*/
            
            $aux = $returns
            ->where('nombres','=','ADRIAN')
            ->leftJoin('tipo_docs','profesores.id_tipo_doc','=','tipo_docs.id')
            ->select(
                'profesores.id','profesores.nombres','profesores.apellidos',
                'tipo_docs.nombre as tipo_doc',
                'profesores.nro_doc')
            ->whereNull('profesores.deleted_at')
            ->get();

            Log::info('Datos para la nueva table: '.json_encode($aux));  

            return Datatables::of($aux)
            ->addColumn('acciones' , function($ret){
                return '<button profesor-id="'.$ret->id.'" class="btn btn-info btn-xs agregar" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';
            })            
            ->make(true); 
        }else{
            Log::info('No paso');
            return json_encode("Los filtros no son validos.");
        }        
    }

    public function getSelectOptions()
    {
        $tipoDocumentos = TipoDocumento::all();

        return array('documentos' => $tipoDocumentos);
    }

    public function set(Request $r)
    {
        $v = Validator::make($r->all(),$this->_rules);
        if(!$v->fails()){
            //Si le setearon pais busco su id
            if($r->has('pais')){
                $r->pais = Pais::select('id_pais')->where('nombre','=',$r->pais)->get('id_pais')->first(); 
                $r->pais = $r->pais['id_pais'];    
            }        
            $profesor = new Profesor();         
            $profesor->crear($r);
        }else{
            Log::info('El profesor no paso la verificacion.'); 
        }
    }

    public function getData(Request $r,$id)
    {
        $profesor = Profesor::find($id);
        $nombre_pais = null;
        $id_tipo_doc = $profesor->id_tipo_doc;
        if($id_tipo_doc === 6 || $id_tipo_doc === 5){
            $pais = Pais::find($profesor->id_pais);    
            $nombre_pais = $pais->nombre;
        }        
        $profesor = array('profesor' => $profesor,'pais' => $nombre_pais);
        $ret = array_merge($profesor,$this->getSelectOptions());
        return view('profesores/modificar',$ret);
    }

    public function modificar(Request $r,$id)
    {
        $profesor = Profesor::find($id);
        Log::info(json_encode($profesor));
        Log::info(json_encode($r->id_tipo_doc));

        if($r->id_tipo_doc === '6' || $r->id_tipo_doc === '5'){
            Log::info('Busca el id del pais');
            $r->pais = Pais::select('id')->where('nombre','=',$r->pais)->get('id')->first(); 
            $r->pais = $r->pais['id'];
            Log::info(json_encode($r->pais));
        }

        $profesor->modificar($r);    
    }

    public function borrar(Request $r,$id)
    {
        $profesor = Profesor::find($id);
        $profesor->delete();
    }
}
