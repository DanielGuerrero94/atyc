<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\AreaTematica;
use App\LineaEstrategica;
use App\Provincia;
use App\Periodo;
use App\Curso;
use DB;
use Auth;
use Validator;
use Datatables;

class cursosController extends Controller
{
	private 
	$_rules = [
	'nombre' => 'required|string',
	'duracion' => 'required|numeric',
	'fecha' => 'required',
	'id_area_tematica' => 'required|numeric',
	'id_linea_estrategica' => 'required|numeric',
	'id_provincia' => 'required|numeric'
	];

	private 
	$_filters = [
	'nombre' => 'string',
	'duracion' => 'numeric',
	'edicion' => 'numeric',
	'id_provincia' => 'numeric',
	'id_linea_estrategica' => 'numeric',
	'id_area_tematica' => 'numeric',
	'id_periodo' => 'numeric',
	'desde' => 'string',
	'hasta' => 'string'];

	private $botones = ['fa fa-pencil-square-o','fa fa-trash-o'];

	//Lo tengo aca pero lo podria tener en otra clase porque lo pueden llegar a usar todas las tablas porque estan en latin1 pero lo muestro en utf-8

	//En el caso que pase todo a eloquent puedo seguir el caso ejemplo del model efector que esta en el sirge, usando getAttribute y setAttribute para poder hacerlo directamente asi
	public static function convertToUtf8($string){ return $converted = iconv ('latin1' , 'utf-8' , $string); }


	//Para ahorrarme escribir siempre que connection usar
	public function query($query)
	{    	
		return DB::connection('g_plannacer')->select($query);
	}

	public function get()
	{
		return view('cursos',$this->getSelectOptions());
	}

	public function getJoined()
	{
    	//Me traigo L.f_virtual no tengo idea pra que sirve(preguntar);
		$query = "SELECT C.id,C.nombre_curso,date(C.fecha_curso) as \"fecha_curso\",C.edicion,C.horas_duracion,A.area_tematica as \"area_tematica\",C.modalidad,P.descripcion as \"provincia_organizadora\",C.f_c,L.lineas_estrategicas as \"linea_estrategica\",L.f_virtual  FROM cursos C INNER JOIN areas_tematicas A ON A.id = C.area_tematica INNER JOIN lineas_estrategicas L ON L.id = C.linea_estrategica INNER JOIN provincias P ON P.id = C.provincia_organizadora";
		return $this->query($query);
	}

	public function getTabla()
	{
		$returns = Curso::select('id_curso','nombre','fecha','edicion','duracion','id_area_tematica','id_linea_estrategica','id_provincia')	
		->with([
			'area_tematica',
			'linea_estrategica',
			'provincia'
		]);				

		if(Auth::user()->id_provincia != 25){           
            $returns = $returns->where('id_provincia',Auth::user()->id_provincia);
        }

		$returns = collect($returns->get());

		return Datatables::of($returns)
		->addColumn('acciones' , function($ret){
			return '<a href="cursos/'.$ret->id_curso.'"><button data-id="'.$ret->id_curso.'" class="btn btn-info btn-xs editar" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>'.'<button data-id="'.$ret->id_curso.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
		})            
		->make(true); 	
	}

	//Cambiar esta funcion urgente
	public function getAprobadosPorAlumno($alumno)	
	{
		$returns = Curso::whereHas('alumnos',function ($query) use ($alumno)
		{
			$query->where('id_alumno',$alumno);
		})
		->select('id_curso','nombre','duracion','id_provincia')
		->with('provincia')
		->get();

		return Datatables::of($returns)
			->addColumn('acciones' , function($ret){
				return '<a href="'.url('cursos').'/'.$ret->id_curso.'"><button class="btn btn-info btn-xs" title="Ver"><i class="fa fa-search" aria-hidden="true"></i></button></a>';
			})->make(true);
		}

		public function getDictadosPorProfesor($profesor)
		{
			$returns = Curso::whereHas('profesores',function ($query) use ($profesor)
			{
				$query->where('id_profesor',$profesor);
			})			
			->select('id_curso','nombre','fecha','id_provincia')			
			->with('provincia')
			->get();

			return Datatables::of($returns)
			->addColumn('acciones' , function($ret){
				return '<a href="'.url('cursos').'/'.$ret->id_curso.'"><button class="btn btn-info btn-xs" title="Ver"><i class="fa fa-search" aria-hidden="true"></i></button></a>';
			})->make(true);
		}

		public function getAlta()
		{		
			return view('cursos/alta',$this->getSelectOptions());
		}

		//Typeahead
		public function getNombres()
		{	
			$nombres = Curso::select('nombre')
			->groupBy('nombre')
			->orderBy('nombre')
			->get()
			->map(function($item,$key){
				return $item->nombre;
			});

			$ret = array(
				'status' => true,
				'error' => null,
				'data' => array(
					'info' => $nombres
					)
				);

			return json_encode($ret);
		}

		public function set(Request $r)
		{
			$v = Validator::make($r->all(),$this->_rules);
			if(!$v->fails()){
				$curso = new Curso();
				$curso->crear($r);
				Log::info(json_encode($curso));
			}else{
				Log::info('El curso no paso la verificacion.'); 
			}
		}

		public function getProfesores()
		{
		/*$curso = Curso::find('40');
		$curso->profesores()->attach('207');*/

		$curso = Curso::find('300')->profesores()->get();
		Log::info(json_encode($curso));
		return json_encode($curso);
	}

	public function getAlumnos($id)
	{
		try {
			$curso = Curso::findOrFail($id)
			->alumnos()		
			->join('sistema.provincias','sistema.provincias.id_provincia','=','alumnos.id_provincia')
			->join('sistema.tipos_documentos','sistema.tipos_documentos.id_tipo_documento','=','alumnos.alumnos.id_tipo_documento')
			->select('alumnos.id_alumno','nombres','apellidos','sistema.tipos_documentos.nombre as tipo_doc','nro_doc','sistema.provincias.nombre as provincia')
			->get();
		} catch (ModelNotFoundException $e) {
			$curso = null;
		}

		$returns = collect($curso)->map(function ($item,$key){
			return array('id_alumno' => $item['id_alumno'],
				'nombres' => $item['nombres'],
				'apellidos' => $item['apellidos'],
				'tipo_doc' => $item['tipo_doc'],
				'nro_doc' => $item['nro_doc'],
				'provincia' => $item['provincia']);
		});

		return Datatables::of($returns)
		->addColumn('acciones' , function($ret){
			return '<a href="'.url('alumnos/'.$ret['id_alumno']).'"><button data-id="'.$ret['id_alumno'].'" class="btn btn-info btn-xs ver" title="Ver"><i class="fa fa-search" aria-hidden="true"></i></button></a>';
		})            
		->make(true); 		
	}

	public function getCountAlumnos($id)
	{
		$query = "SELECT C.nombre,C.edicion,C.fecha,count (*) as cantidad_alumnos, CONCAT(LE.numero,'-',LE.nombre) as \"linea_estrategica\",AT.nombre as \"area_tematica\",P.nombre as \"provincia\",C.duracion from cursos.cursos C 
		left join cursos.cursos_alumnos CA ON CA.id_cursos = C.id_curso 
		left join alumnos.alumnos A ON CA.id_alumnos = A.id_alumno
		inner join sistema.provincias P ON P.id_provincia = C.id_provincia
		inner join cursos.areas_tematicas AT ON AT.id_area_tematica = C.id_area_tematica 
		inner join cursos.lineas_estrategicas LE ON LE.id_linea_estrategica = C.id_linea_estrategica";

		if($id !== '0'){
			$query .= " WHERE C.id_provincia = '".$id."'";	
		}

		$query .= " group by C.id_curso,C.nombre,LE.numero,LE.nombre,AT.nombre,P.nombre
		order by C.nombre,C.edicion
		";

		$cursos = DB::select($query);
		$cursos = collect($cursos);

		return Datatables::of($cursos)
		->make(true); 	
	}

	public function getAlumnosDeCursosPorProvincia($id)
	{
		if($id == 0){
			$cursos = Curso::where('id_provincia','=',$id)
			->alumnos()
			->get();
		}else{
			$cursos = Curso::whereNull('deleted_at')
			->alumnos()
			->get();
		}

		return $cursos;
	}

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

	private function queryLogica(Request $r,$filtros)
	{
		//Filtros las que estan vacias si es que me las pasaron
		$filtered = $filtros->filter(function ($value,$key)
		{
			return $value != "" && $value != "0";
		});

		$returns = DB::table('cursos.cursos');

		//Con esto logro que las provincias solo vean lo que les corresponda pero la uec tenga disponible los filtros 
		if (Auth::user()->id_provincia != 25) {
			$returns = $returns->where('cursos.cursos.id_provincia','=',Auth::user()->id_provincia);
		}

		foreach ($filtered as $key => $value) {
			if($key == 'nombre'){
				$returns = $returns->where('cursos.cursos.'.$key,'ilike','%'.$value.'%');                           
			}elseif ($key == 'desde') {
				$returns = $returns->where('cursos.cursos.fecha','>',$value);
			}elseif ($key == 'hasta') {
				$returns = $returns->where('cursos.cursos.fecha','<',$value);
			}elseif($key == 'id_periodo'){
				$periodo = Periodo::find($value);
				$returns = $returns->where('cursos.cursos.fecha','>',$periodo->desde);
				$returns = $returns->where('cursos.cursos.fecha','<',$periodo->hasta);
			}else{
				$returns = $returns->where('cursos.cursos.'.$key,'=',$value);                           
			}
		}

		$returns = $returns
		->leftJoin('cursos.areas_tematicas','cursos.cursos.id_area_tematica','=','cursos.areas_tematicas.id_area_tematica')
		->leftJoin('cursos.lineas_estrategicas','cursos.cursos.id_linea_estrategica','=','cursos.lineas_estrategicas.id_linea_estrategica')
		->leftJoin('sistema.provincias','cursos.cursos.id_provincia','=','sistema.provincias.id_provincia')
		->select(
			'cursos.cursos.id_curso','cursos.cursos.nombre','cursos.cursos.fecha',
			'cursos.cursos.edicion','cursos.cursos.duracion',
			'cursos.areas_tematicas.nombre as area_tematica',
			'cursos.lineas_estrategicas.nombre as linea_estrategica',
			'sistema.provincias.nombre as provincia')		
		->whereNull('cursos.cursos.deleted_at');

		return collect($returns->get());
	}

	public function getFiltrado(Request $r){
		$filtros = collect($r->only('filtros'));
		$filtros = collect($filtros->get('filtros'));

		$v = Validator::make($filtros->all(),$this->_filters);
		if(!$v->fails()){

			$aux = $this->queryLogica($r,$filtros);  

			$tabla = Datatables::of($aux)
			->addColumn('acciones' , function($ret) use ($r){

				$accion = $r->has('botones')?$r->botones:null;

				$editarYEliminar = '<a href="'.url('alumnos').'/'.$ret->id_curso.'"><button alumno-id="'.$ret->id_curso.'" class="btn btn-info btn-xs editar" title="Editar"><i class="'.$this->botones[0].'" aria-hidden="true"></i></button></a>'.'<button alumno-id="'.$ret->id_curso.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="'.$this->botones[1].'" aria-hidden="true"></i></button>';

				$agregar = '<button data-id="'.$ret->id_curso.'" class="btn btn-info btn-xs agregar" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

				$botones = $editarYEliminar;

				if($accion == 'agregar'){
					$botones = $agregar;
				}           
				return $botones;
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

		$order_by = collect($r->only('order_by'));
		logger(json_encode($order_by));

		$data = $this->queryLogica($r,$filtros,$order_by);
		$datos = ['cursos' => $data];
		$path = "cursos_filtrados_".date("Y-m-d_H:i:s");

		Excel::create($path, function ($excel) use ($datos){
			$excel->sheet('Reporte', function ($sheet) use ($datos){
				$sheet->setHeight(1, 20);
				$sheet->loadView('excel.cursos', $datos);
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

		return PDF::save($header,$column_size,10,$mapped);

		/*$pdf = PDF::loadView('excel.cursos',$datos)->save($path.".pdf");
		return $path;*/
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
			'area_tematica',
			'linea_estrategica',
			'provincia'
		])
		->where('id_curso',$id)
		->first();

		//De la base de datos me viene con '-' y en el orden opuesto
		//Lo pongo con '/'
		$f = explode("-",$curso->fecha);
		$curso->fecha = $f[2].'/'.$f[1].'/'.$f[0];

		$curso = array('curso' => $curso);
		$ret = array_merge($this->getSelectOptions(),$curso);

		return view('cursos/modificar',$ret);
	}

	public function modificar(Request $r,$id)
	{
		$curso = Curso::find($id);
		$curso->modificar($r);
	}

	public function borrar(Request $r,$id)
	{
		$curso = Curso::find($id);
		$curso->delete();
	}
}
