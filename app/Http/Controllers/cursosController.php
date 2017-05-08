<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\AreaTematica;
use App\LineaEstrategica;
use App\Provincia;
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


	//Lo tengo aca pero lo podria tener en otra clase porque lo pueden llegar a usar todas las tablas porque estan en latin1 pero lo muestro en utf-8

	//En el caso que pase todo a eloquent puedo seguir el caso ejemplo del model efector que esta en el sirge, usando getAttribute y setAttribute para poder hacerlo directamente asi
	public static function convertToUtf8($string){ return $converted = iconv ('latin1' , 'utf-8' , $string); }


	//Para ahorrarme escribir siempre que connection usar
	public function query($query)
	{    	
		return DB::connection('eLearning')->select($query);
	}

	public function get()
	{
		return view('cursos');
	}

	public function getJoined()
	{
    	//Me traigo L.f_virtual no tengo idea pra que sirve(preguntar);
		$query = "SELECT C.id,C.nombre_curso,date(C.fecha_curso) as \"fecha_curso\",C.edicion,C.horas_duracion,A.area_tematica as \"area_tematica\",C.modalidad,P.descripcion as \"provincia_organizadora\",C.f_c,L.lineas_estrategicas as \"linea_estrategica\",L.f_virtual  FROM cursos C INNER JOIN areas_tematicas A ON A.id = C.area_tematica INNER JOIN lineas_estrategicas L ON L.id = C.linea_estrategica INNER JOIN provincias P ON P.id = C.provincia_organizadora";
		return $this->query($query);
	}

	public function getTabla()
	{
		$returns = DB::table('cursos')
		->leftJoin('area_tematicas','cursos.id_area_tematica','=','area_tematicas.id')
		->leftJoin('linea_estrategicas','cursos.id_linea_estrategica','=','linea_estrategicas.id')
		->leftJoin('provincias','cursos.id_provincia','=','provincias.id')
		->select(
			'cursos.id','cursos.nombre','cursos.fecha',
			'cursos.edicion','cursos.duracion',
			'area_tematicas.nombre as area_tematica',
			'linea_estrategicas.nombre as linea_estrategica',
			'provincias.nombre as provincia')		
		->whereNull('cursos.deleted_at');

		$esProvincia = false;

		$roles = Auth::user()->roles();
		
		foreach ($roles as $role) {
			foreach ($role as $key => $value) {
				if($key == 'name' && $value == 'provincia'){
					$esProvincia = true;  
				}
			}			
		}		

		if($esProvincia){			
			$id_provincia = Auth::user()->id_provincia;
			$returns = $returns->where('id_provincia','=',$id_provincia);
		}					

		$returns = collect($returns->get());

		return Datatables::of($returns)
		->addColumn('accion' , function($ret){
			return '<button data-id="'.$ret->id.'" class="btn btn-info btn-xs editar" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'.'<button data-id="'.$ret->id.'" class="btn btn-danger btn-xs eliminar" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
		})            
		->make(true); 	
	}

	public function getAprobadosPorAlumno($alumno)	
	{
		$query = "SELECT C.nombre_curso as \"Nombre curso\",C.horas_duracion \"Horas duracion\",C.modalidad as \"Modalidad\",P.descripcion as \"Provincia organizadora\" FROM g_plannacer.cursos_alumnos CA
		INNER JOIN g_plannacer.alumnos A ON A.id = CA.alumno 
		INNER JOIN g_plannacer.cursos C ON C.id = CA.curso
		INNER JOIN g_plannacer.provincias P ON P.id = C.provincia_organizadora 
		WHERE A.id =".$alumno;

		/*$returns = DB::table('cursos_alumnos')
		->join('alumnos','cursos_alumnos.alumno','=','alumnos.id')
		->join('cursos','cursos_alumnos.curso','=','cursos.id')
		->join('provincias','cursos.provincia_organizadora','=','provincias.id')
		->select(
			'cursos.nombre_curso as "Nombre curso"',
			'cursos.horas_duracion "Horas duracion"',
			'cursos.modalidad as "Modalidad"',
			'provincias.descripcion as "Provincia organizadora"')	
			->get();*/

			$returns = collect($this->query($query));		
			return Datatables::of($returns)->make(true);
		}

		public function getAlta()
		{		
			return view('cursos/alta',$this->getSelectOptions());
		}

		public function getNombres()
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
			->get();	
		} catch (ModelNotFoundException $e) {
			$curso = null;
		}

		$returns = collect($curso);

		return Datatables::of($returns)
		->addColumn('accion' , function($ret){
			return '<button data-id="'.$ret->id.'" class="btn btn-info btn-xs editar" title="Editar"><i class="fa fa-check-circle-o" aria-hidden="true"></i></button>';
		})            
		->make(true); 		
	}

	public function getCountAlumnos($id)
	{
		/*$cursos = Curso::where('id_provincia','=',$id)
		->groupBy('nombre');*/

		$query = "SELECT C.nombre,C.edicion,C.fecha,count (*) as \"cantidad_alumnos\", CONCAT(LE.numero,'-',LE.nombre) as \"linea_estrategica\",AT.nombre as \"area_tematica\",P.nombre as \"provincia\",C.duracion from cursos C 
		left join cursos_alumnos CA ON CA.id_cursos = C.id 
		left join alumnos A ON CA.id_alumnos = A.id
		inner join provincias P ON P.id = C.id_provincia
		inner join area_tematicas AT ON AT.id = C.id_area_tematica 
		inner join linea_estrategicas LE ON LE.id = C.id_linea_estrategica";

		if($id !== '0'){
			$query .= " WHERE C.id_provincia = '".$id."'";	
		}

		$query .= " group by C.id,C.nombre,LE.numero,LE.nombre,AT.nombre,P.nombre
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

		return array('areas_tematicas' => $areas,'lineas_estrategicas' => $lineas,'provincias' => $provincias);
	}

	public function getData($id)
	{		
		$curso = Curso::find($id);		

		$area = AreaTematica::find($curso->id_area_tematica)->nombre;
		$linea = LineaEstrategica::find($curso->id_linea_estrategica)->nombre;
		$provincia = Provincia::find($curso->id_provincia)->nombre;

		//De la base de datos me viene con '-' y en el orden opuesto
		//Lo pongo con '/'
		$f = explode("-",$curso->fecha);
		$curso->fecha = $f[2].'/'.$f[1].'/'.$f[0];

		$return = array('curso' => $curso,'area' => $area,'linea' => $linea,'provincia' => $provincia);

		$ret = array_merge($return,$this->getSelectOptions());

		return view('cursos/modificar',$ret);
	}

	public function modificar(Request $r,$id)
	{
		Log::info(json_encode($r->nombre));
		Log::info(json_encode($r->id_area_tematica));
		Log::info(json_encode($r->id_provincia));
		$curso = Curso::find($id);
		$curso->modificar($r);
	}

	public function borrar(Request $r,$id)
	{
		$curso = Curso::find($id);
		$curso->delete();
	}
}
