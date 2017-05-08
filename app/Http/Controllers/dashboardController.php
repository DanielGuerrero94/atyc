<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Datatables;

class dashboardController extends Controller
{
	//Para ahorrarme escribir siempre que connection usar
	public function query($query)
	{    	
		return DB::connection('eLearning')->select($query);
	}

	public function get()
	{
		$alumnos = $this->getCountAlumnos();
		$profesores = $this->getCountProfesores();
		$cursos = $this->getCountCursos();

		$counts = array('alumnos' => $alumnos,'cursos' => $cursos,'profesores' => $profesores);

		$cursos_areas_temaricas = $this->getCountCursosPorAreaTematica();

		$cursos_lineas_estrategicas = $this->getCountCursosPorLineaEstrategica();

		$tortas = array('cursos_areas_temaricas' => $cursos_areas_temaricas,'cursos_lineas_estrategicas' => $cursos_lineas_estrategicas);

		$graficos = array(
		'cursos2013' => $this->getCursosPorAnio('2013'),
		'cursos2014' => $this->getCursosPorAnio('2014'),
		'cursos2015' => $this->getCursosPorAnio('2015'),
		'cursos2016' => $this->getCursosPorAnio('2016'));

		$returns = array_merge($counts,$tortas);
		$returns = array_merge($returns,$graficos);
		return json_encode($returns);
	}

	private function getCountTabla($tabla)
	{
		return DB::table($tabla)
        ->whereNull('deleted_at')
        ->get();
	}

	private function getCountAlumnos()
	{
		return $this->getCountTabla("alumnos")->count();
	}

	private function getCountCursos()
	{
		return $this->getCountTabla("cursos")
		->groupBy('nombre')->count();
	}

	private function getCountProfesores()
	{
		return $this->getCountTabla("profesors")->count();	
	}

	private function getCountCursosPorAreaTematica()
	{
		return DB::table('cursos')
		->whereNull('cursos.deleted_at')
		->join('area_tematicas','cursos.id_area_tematica','=','area_tematicas.id')        
		->select('area_tematicas.nombre',DB::raw('count(*) as cantidad'))
		->groupBy('area_tematicas.nombre')
        ->get();	
	}

	private function getCountCursosPorLineaEstrategica()
	{
		return DB::table('cursos')
		->whereNull('cursos.deleted_at')
		->join('linea_estrategicas','cursos.id_linea_estrategica','=','linea_estrategicas.id')        
		->select('linea_estrategicas.nombre',DB::raw('count(*) as cantidad'))
		->groupBy('linea_estrategicas.nombre')
        ->get();
	}

	private function getCursosPorAnio($anio)
	{
		return DB::table('cursos')
		->whereNull('cursos.deleted_at')      
		->select(DB::raw('count(*) as cantidad'))
		->whereYear('cursos.fecha',$anio)
		->groupBy(DB::raw('EXTRACT(ISOYEAR FROM cursos.fecha),EXTRACT(MONTH FROM cursos.fecha)'))
		->orderBy(DB::raw('EXTRACT(ISOYEAR FROM cursos.fecha),EXTRACT(MONTH FROM cursos.fecha)'))
        ->get();	
	}


}
