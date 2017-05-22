<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Curso extends Model
{
	
	use SoftDeletes;

	protected $table = "cursos.cursos";

	protected $dates = ['deleted_at'];

	public function profesores()
	{
		return $this->belongsToMany('App\Profesor','cursos_profesores','id_cursos','id_profesores')->withTimestamps();
	}

	public function alumnos()
    {   
        return $this->belongsToMany('App\Alumno','cursos_alumnos','id_cursos','id_alumnos')->withTimestamps();
    }

	public function provincia()
    {
        return $this->hasOne('App\Provincia', 'id_provincia', 'id_provincia');
    }

	public function area_tematica()
    {
        return $this->hasOne('App\AreaTematica', 'id_area_tematica', 'id_area_tematica');
    }

	public function linea_estrategica()
    {
        return $this->hasOne('App\LineaEstrategica', 'id_linea_estrategica', 'id_linea_estrategica');
    }

	public function crear(Request $r)
	{
		$this->nombre = $r->nombre;
		$this->id_provincia = $r->id_provincia;
		$this->id_area_tematica = $r->id_area_tematica;
		$this->id_linea_estrategica = $r->id_linea_estrategica;
		$this->fecha = $r->fecha;
		$this->duracion = $r->duracion;

		/*Tengo que buscar cuantas ocurrencias hay del nombre de curso para saber que edicion es, podria ser un trigger en insert*/

		$edicion = Curso::where('nombre','=',$r->nombre)->count();

		$this->edicion = $edicion + 1;	
		$this->save();	
		return $this;
	}

	public function modificar(Request $r)
	{
		$this->nombre = $r->nombre;
		$this->id_provincia = $r->id_provincia;
		$this->id_area_tematica = $r->id_area_tematica;
		$this->id_linea_estrategica = $r->id_linea_estrategica;
		$this->fecha = $r->fecha;
		$this->duracion = $r->duracion;
		$this->save();
		return $this;	
	}

	public static function getByCuie($cuie)
	{
		return DB::table('cursos.cursos')
        ->join('cursos.cursos_alumnos','cursos.cursos_alumnos.id_cursos','=','cursos.cursos.id_curso')
        ->join('alumnos.alumnos','alumnos.alumnos.id_alumno','=','cursos.cursos_alumnos.id_alumnos')
        ->select('cursos.cursos.id_curso','cursos.cursos.nombre','cursos.cursos.fecha',DB::raw('count(*) as alumnos'))
        ->where('alumnos.alumnos.establecimiento1','=',$cuie)
        ->groupBy('cursos.cursos.id_curso','cursos.cursos.nombre','cursos.cursos.fecha')
        ->orderBy('cursos.cursos.fecha','desc')
        ->get();
	}
}
