<?php

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

class cursosController extends AbmController
{
	private 
	$rules = [
	'nombre' => 'required|string',
	'duracion' => 'required|numeric',
	'fecha' => 'required',
	'id_area_tematica' => 'required|numeric',
	'id_linea_estrategica' => 'required|numeric',
	'id_provincia' => 'required|numeric'
	], 
	$filters = [
	'nombre' => 'string',
	'duracion' => 'numeric',
	'edicion' => 'numeric',
	'id_provincia' => 'numeric',
	'id_linea_estrategica' => 'numeric',
	'id_area_tematica' => 'numeric',
	'id_periodo' => 'numeric',
	'desde' => 'string',
	'hasta' => 'string'
	], 
	$botones = [
	'fa fa-pencil-square-o',
	'fa fa-trash-o'
	];

	//Lo tengo aca pero lo podria tener en otra clase porque lo pueden llegar a usar todas las tablas porque estan en latin1 pero lo muestro en utf-8

	//En el caso que pase todo a eloquent puedo seguir el caso ejemplo del model efector que esta en el sirge, usando getAttribute y setAttribute para poder hacerlo directamente asi
	public static function convertToUtf8($string){ return $converted = iconv ('latin1' , 'utf-8' , $string); }


	//Para ahorrarme escribir siempre que connection usar
	public function query($query)
	{    	
		return DB::connection('g_plannacer')->select($query);
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
		return json_encode(Curso::all());
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('cursos/alta',$this->getSelectOptions());
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	logger(json_encode($request->all()));
    	$v = Validator::make($request->all(),$this->rules);
    	if(!$v->fails()){
    		$curso = new Curso();
    		$curso->crear($request);

    		if($request->has('alumnos')){
    			$alumnos = explode(',',$request->get('alumnos'));
    			logger(json_encode($alumnos));
    			$curso->alumnos()->attach($alumnos);
    		}

    		if($request->has('profesores')){
    			$profesores = explode(',',$request->get('profesores'));
    			logger(json_encode($profesores));
    			$curso->profesores()->attach($profesores);				
    		}

    	}else{
    		logger($v->errors());
    		logger('El curso no paso la verificacion.'); 
    	}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$curso = Curso::select('id_curso','nombre','edicion','duracion','fecha','id_area_tematica','id_linea_estrategica','id_provincia')
    	->with([
    		'areaTematica',
    		'lineaEstrategica',
    		'provincia'
    		])
    	->where('id_curso',$id)
    	->first();

		//De la base de datos me viene con '-' y en el orden opuesto
		//Lo pongo con '/'
    	$f = explode("-",$curso->fecha);
    	$curso->fecha = $f[2].'/'.$f[1].'/'.$f[0];

    	$curso = array('curso' => $curso);
    	return array_merge($this->getSelectOptions(),$curso);		
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	return view('cursos/modificar',$this->show($id));
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
    	$curso = Curso::findOrFail($id);

    	if($request->has('alumnos')){
    		$curso->alumnos()->sync($request->get('alumnos'));
    	}

    	if($request->has('profesores')){
    		$curso->profesores()->sync($request->get('profesores'));
    	}
    	
    	$curso->modificar($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {    	
    	return Curso::findOrFail($id)->delete();
    }

    /**
     * View para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
    	return view('cursos',$this->getSelectOptions());
    }

	/**
     * Devuelve la informacion para abm.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $request['botones']
     * @return \Illuminate\Http\Response
     */
	public function getTabla(Request $request)
	{
		$query = Curso::select('id_curso','nombre','fecha','edicion','duracion','id_area_tematica','id_linea_estrategica','id_provincia')	
		->with([
			'areaTematica',
			'lineaEstrategica',
			'provincia'
			])
		->segunProvincia();	

		return $this->toDatatable($request,$query); 	
	}

	public function getAprobadosPorAlumno($alumno)	
	{
		$returns = Curso::whereHas('alumnos',function ($query) use ($alumno)
		{
			$query->where('alumnos.id_alumno',$alumno);
		})
		->select('id_curso','nombre','duracion','id_provincia')
		->with('provincia');

		return Datatables::of($returns)
		->addColumn('acciones' , function($ret){
			return '<a href="'.url('cursos').'/'.$ret->id_curso.'"><button class="btn btn-info btn-xs" title="Ver"><i class="fa fa-search" aria-hidden="true"></i></button></a>';
		})->make(true);
	}

	public function getDictadosPorProfesor($profesor)
	{
		$returns = Curso::whereHas('profesores',function ($query) use ($profesor)
		{
			$query->where('profesores.id_profesor',$profesor);
		})			
		->select('id_curso','nombre','fecha','id_provincia')			
		->with('provincia');

		return Datatables::of($returns)
		->addColumn('acciones' , function($ret){
			return '<a href="'.url('cursos').'/'.$ret->id_curso.'"><button class="btn btn-info btn-xs" title="Ver"><i class="fa fa-search" aria-hidden="true"></i></button></a>';
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
		->map(function($item,$key){
			return $item->nombre;
		});

		return $this->typeaheadResponse($nombres);
	}

	public function getProfesores($id)
	{
		$curso = Curso::findOrFail($id)
		/*->with([
			'profesores' => function($q){
				$q->with(['tipoDocumento']);
			}
		])
		->select('sistema.profesores.id_profesor','nombres','apellidos','profesores.tipoDocumento.nombre','nro_doc')
		->get();*/
		->profesores()
		->join('sistema.tipos_documentos','sistema.tipos_documentos.id_tipo_documento','=','sistema.profesores.id_tipo_documento')
		->select('profesores.id_profesor','nombres','apellidos','sistema.tipos_documentos.nombre as tipo_doc','nro_doc')
		->get();

		$returns = collect($curso)->map(function ($item,$key){
			return array('id_profesor' => $item['id_profesor'],
				'nombres' => $item['nombres'],
				'apellidos' => $item['apellidos'],
				'id_tipo_documento' => $item['tipo_doc'],
				'nro_doc' => $item['nro_doc']);
		});

		return Datatables::of($returns)
		->addColumn('acciones' , function($ret){
			return '<a href="'.url('profesores/'.$ret['id_profesor']).'"><button data-id="'.$ret['id_profesor'].'" class="btn btn-info btn-xs ver" title="Ver"><i class="fa fa-search" aria-hidden="true"></i></button></a>';
		})            
		->make(true); 
	}

	public function getAlumnos($id)
	{
		$curso = Curso::findOrFail($id)
		->alumnos()		
		->join('sistema.provincias','sistema.provincias.id_provincia','=','alumnos.id_provincia')
		->join('sistema.tipos_documentos','sistema.tipos_documentos.id_tipo_documento','=','alumnos.alumnos.id_tipo_documento')
		->select('alumnos.id_alumno','nombres','apellidos','sistema.tipos_documentos.nombre as tipo_doc','nro_doc','sistema.provincias.nombre as provincia')
		->get();

		$returns = collect($curso)->map(function ($item,$key){
			return array('id_alumno' => $item['id_alumno'],
				'nombres' => $item['nombres'],
				'apellidos' => $item['apellidos'],
				'id_tipo_documento' => $item['tipo_doc'],
				'nro_doc' => $item['nro_doc'],
				'provincia' => $item['provincia']);
		});

		return Datatables::of($returns)
		->addColumn('acciones' , function($ret){
			return '<a href="'.url('alumnos/'.$ret['id_alumno']).'"><button data-id="'.$ret['id_alumno'].'" class="btn btn-info btn-xs ver" title="Ver"><i class="fa fa-search" aria-hidden="true"></i></button></a>';
		})            
		->make(true); 		
	}

	public function getCountAlumnos(Request $r,$id)
	{
		$query = $this->queryCountAlumnos($r,$id);

		$cursos = DB::select($query);
		$cursos = collect($cursos);

		return Datatables::of($cursos)
		->make(true); 	
	}

	public function queryCountAlumnos(Request $r,$id_provincia)
	{
		$query = "SELECT C.nombre,C.edicion,C.fecha,count (*) as cantidad_alumnos, CONCAT(LE.numero,'-',LE.nombre) as linea_estrategica,AT.nombre as area_tematica,P.nombre as provincia,C.duracion from cursos.cursos C 
		left join cursos.cursos_alumnos CA ON CA.id_curso = C.id_curso 
		left join alumnos.alumnos A ON CA.id_alumno = A.id_alumno
		inner join sistema.provincias P ON P.id_provincia = C.id_provincia
		inner join cursos.areas_tematicas AT ON AT.id_area_tematica = C.id_area_tematica 
		inner join cursos.lineas_estrategicas LE ON LE.id_linea_estrategica = C.id_linea_estrategica";

		if($id_provincia !== '0' and $id_provincia !== 25){
			$query .= " WHERE C.id_provincia = '".$id_provincia."'";	
		}

		$query .= "group by C.id_curso,C.nombre,LE.numero,LE.nombre,AT.nombre,P.nombre";

		return $query;
	}

	public function getAlumnosDeCursosPorProvincia($id)
	{
		if($id == 0){
			$cursos = Curso::where('id_provincia',$id);
		}else{
			$cursos = Curso::whereNull('deleted_at');
		}

		$cursos = $cursos->alumnos()->get();
		return $cursos;
	}

	/**
     * Opciones para los selects del front end.
     *
     * @return \Illuminate\Http\Response
     */
	public function getSelectOptions()
	{
		$areas = AreaTematica::orderBy('nombre')->get();
		$lineas = LineaEstrategica::orderBy('numero')->get();
		$provincias = Provincia::orderBy('nombre')->get();
		$periodos = Periodo::all();

		return array(
			'areas_tematicas' => $areas,
			'lineas_estrategicas' => $lineas,
			'provincias' => $provincias,
			'periodos' => $periodos);
	}

	private function queryLogica(Request $r,$filtros,$orderBy)
	{
		//Filtros las que estan vacias si es que me las pasaron
		$filtered = $filtros->filter(function ($value,$key)
		{
			return $value != "" && $value != "0";
		});

		$query = Curso::leftJoin('cursos.areas_tematicas','cursos.cursos.id_area_tematica','=','cursos.areas_tematicas.id_area_tematica')
		->leftJoin('cursos.lineas_estrategicas','cursos.cursos.id_linea_estrategica','=','cursos.lineas_estrategicas.id_linea_estrategica')
		->leftJoin('sistema.provincias','cursos.cursos.id_provincia','=','sistema.provincias.id_provincia')
		->select(
			'cursos.cursos.id_curso','cursos.cursos.nombre','cursos.cursos.fecha',
			'cursos.cursos.edicion','cursos.cursos.duracion',
			'cursos.areas_tematicas.nombre as area_tematica',
			'cursos.lineas_estrategicas.nombre as linea_estrategica',
			'sistema.provincias.nombre as provincia')
		->segunProvincia();

		foreach ($filtered as $key => $value) {
			if($key == 'nombre'){
				$query = $query->where('cursos.cursos.'.$key,'ilike', '%'.$value.'%');
			}elseif ($key == 'desde') {
				$query = $query->where('cursos.cursos.fecha','>',$value);
			}elseif ($key == 'hasta') {
				$query = $query->where('cursos.cursos.fecha','<',$value);
			}elseif($key == 'id_periodo'){
				$periodo = Periodo::find($value);
				$query = $query->where('cursos.cursos.fecha','>',$periodo->desde);
				$query = $query->where('cursos.cursos.fecha','<',$periodo->hasta);
			}else{
				$query = $query->where('cursos.cursos.'.$key,'=',$value);                           
			}
		}

		return $query;
	}

	public function getFiltrado(Request $r){
		$filtros = collect($r->only('filtros'));
		$filtros = collect($filtros->get('filtros'));

		$v = Validator::make($filtros->all(),$this->filters);
		if(!$v->fails()){

			$query = $this->queryLogica($r,$filtros,null);  

			return $this->toDatatable($r,$query);
		}else{
			return json_encode($v->errors());
		}	
	}

	/**
     * Devuelve en DataTable los resultados con sus correspondientes acciones.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $request['botones']
     * @param  Collection  $resultados
     * @return \Illuminate\Http\Response
     */
	public function toDatatable(Request $r,$resultados)
	{
		return Datatables::of($resultados)
		->addColumn('acciones' , function($ret) use ($r){

			$accion = $r->has('botones')?$r->botones:null;

			$editarYEliminar = '<a href="'.url('cursos').'/'.$ret->id_curso.'"><button data-id="'.$ret->id_curso.'" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones[0].'" aria-hidden="true"></i></button></a>'.'<button data-id="'.$ret->id_curso.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="'.$this->botones[1].'" aria-hidden="true"></i></button>';

			$agregar = '<button data-id="'.$ret->id_curso.'" class="btn btn-info btn-xs agregar" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

			return $accion == 'agregar'?$agregar:$editarYEliminar;
		})
		->make(true);
	}

	/**
     * Corre la query segun filtros y order_by
     * Guarda el resultado en un .xls
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array filtros
     * @param  array order_by
     * @return \Illuminate\Http\Response
     * @return string path al archivo generado
     */
	public function getExcel(Request $r)
	{		
		$filtros = collect($r->only('filtros'));
		$filtros = collect($filtros->get('filtros'));

		$order_by = collect($r->only('order_by'));

		$data = $this->queryLogica($r,$filtros,$order_by)->get();
		$datos = ['cursos' => $data];
		$path = "acciones_".date("Y-m-d_H:i:s");

		Excel::create($path, function ($excel) use ($datos){
			$excel->sheet('Reporte', function ($sheet) use ($datos){
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
     * @param  array filtros
     * @param  array order_by
     * @return \Illuminate\Http\Response
     * @return string path al archivo generado
     */
	public function getPDF(Request $r)
	{
		$filtros = collect($r->only('filtros'));
		$filtros = collect($filtros->get('filtros'));

		$data = $this->queryLogica($r,$filtros,null)->get();

		logger(json_encode($data));

		$header = array('Nombre','Fecha','Edicion','Duracion','Area Tematica','Linea Estrategica','Provincia');
		$column_size =  array(80,25,15,17,60,60,20);

		$mapped = $data->map(function ($item,$key){
			$curso = array();
			array_push($curso, $item->nombre);
			array_push($curso, $item->fecha);
			array_push($curso, $item->edicion);
			array_push($curso, $item->duracion);
			array_push($curso, $item->area_tematica);
			array_push($curso, $item->linea_estrategica);
			array_push($curso, $item->provincia);	
			return $curso;
		});

		return PDF::save($header, $column_size, 10, $mapped);
	}

	/**
     * Corre la query para el reporte (No deberia estar aca)
     * Guarda el resultado en un .xls
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array filtros
     * @param  array order_by
     * @return \Illuminate\Http\Response
     * @return string path al archivo generado
     */
	public function getExcelReporte(Request $r)
	{		
		$id_provincia = array_key_exists('id_provincia', $r->filtros)?$r->filtros['id_provincia']:Auth::user()->id_provincia;
		$data = DB::select($this->queryCountAlumnos($r,$id_provincia));
		$data = collect($data);
		$datos = ['cursos' => $data];
		$path = "cant_participantes_acciones_".date("Y-m-d_H:i:s");

		Excel::create($path, function ($excel) use ($datos){
			$excel->sheet('Reporte', function ($sheet) use ($datos){
				$sheet->setHeight(1, 20);
				$sheet->loadView('excel.reporte_6', $datos);
			});
		})
		->store('xls');

		return $path;
	}
}