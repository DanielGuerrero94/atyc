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
    'cel' => 'string',
    'tel' => 'string',
    'email' => 'string',//Tiene que ser string porque si en el filtro no quieren ponerlo completo yo lo comparo con un ilike
    'nro_doc' => 'numeric'];

    public function query($query)
    {
    	return DB::connection('eLearning')->select($query);
    }

    public function get()
    {
        return view('profesores',$this->getSelectOptions());
    }    

    public function getTabla(Request $r)
    {
        $returns = Profesor::select('id_profesor','nombres','apellidos','nro_doc','id_tipo_documento')
        ->with('tipo_documento');

        $returns = collect($returns);
        
        return Datatables::of($returns)
        ->addColumn('acciones' , function($ret) use ($r){
            $accion = $r->has('botones')?$r->botones:null;

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

    private function queryLogica(Request $r,$filtros)
    {
        //Filtros las que estan vacias si es que me las pasaron
        $filtered = $filtros->filter(function ($value,$key)
        {
            return $value != "";
        });

            //Mapeo pasando a minuscula
        $mapped = $filtered->map(function ($value,$key)
        {
            $key = mb_strtolower($key);
            return $value;   
        });

            //Otra forma puedo ir agregando clausulas where
            $returns = Profesor::table();
            foreach ($filtered as $key => $value) {

                if($key == 'nombres' || $key == 'apellidos' || $key == 'email'){
                    $returns = $returns->where('profesores.'.$key,'ilike','%'.$value.'%');                           
                }else{
                    $returns = $returns->where('profesores.'.$key,'=',$value);                           
                }
            }

            $returns = $returns
            ->leftJoin('tipo_docs','profesors.id_tipo_doc','=','tipo_docs.id')
            ->select(
                'profesors.id','profesors.nombres','profesors.apellidos',
                'tipo_docs.nombre as tipo_doc',
                'profesors.nro_doc')
            ->whereNull('profesors.deleted_at');

            return collect($returns->get()); 
        }

        public function getFiltrado(Request $r)
        {
            $filtros = collect($r->only('filtros'));
            $filtros = collect($filtros->get('filtros'));

        //Tengo que crear un metodo lo suficientemente generico como para poder ponerlo en abmcontroller
        //Hago un test solo por nombre para armar el front end
            $v = Validator::make($filtros->all(),$this->_filters);
            if(!$v->fails()){

                $aux = $this->queryLogica($r,$filtros);        

                $reto = Datatables::of($aux)
                ->addColumn('acciones' , function($ret){

                    $accion = Input::get('botones');

                    $editarYEliminar = '<button data-id="'.$ret->id.'" class="btn btn-info btn-xs editar" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'.'<button data-id="'.$ret->id.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';

                    $agregar = '<button profesor-id="'.$ret->id.'" class="btn btn-info btn-xs agregar" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

                    $botones = $editarYEliminar;

                    if($accion == 'agregar'){
                        $botones = $agregar;
                    }           
                    return $botones;
                })            
                ->make(true);


                return $reto;
            }else{
                Log::info('No paso');
                Log::info($v->errors());
                return json_encode($v->errors());
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

    public function getExcel(Request $r)
        {       
            $filtros = collect($r->only('filtros'));
            $filtros = collect($filtros->get('filtros'));

            $data = $this->queryLogica($r,$filtros);
            $datos = ['profesores' => $data];
            $path = "profesores_filtrados_".date("Y-m-d_H:i:s");

            Excel::create($path, function ($excel) use ($datos){
                $excel->sheet('Reporte', function ($sheet) use ($datos){
                    $sheet->setHeight(1, 20);
                    $sheet->loadView('excel.profesores', $datos);
                });
            })
            ->store('xls');

            return $path;
        }

        public function getPDF(Request $r)
        {
            $filtros = collect($r->only('filtros'));
            $filtros = collect($filtros->get('filtros'));

            $data = $this->queryLogica($r,$filtros);
            $header = array('Nombres','Apellidos','Tipo doc','Nro doc');
            $column_size = array(65, 65, 25, 35);
            
            $mapped = $data->map(function ($item,$key){
                $profesor = array();
                array_push($profesor, $item->nombres);
                array_push($profesor, $item->apellidos);
                array_push($profesor, $item->tipo_doc);
                array_push($profesor, $item->nro_doc);
                return $profesor;
            });

            return PDF::save($header,$column_size,14,$mapped);
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
