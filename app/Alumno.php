<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;

class Alumno extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function cursos()
    {   
        return $this->belongsToMany('App\Curso','cursos_alumnos','id_cursos','id_alumnos')->withTimestamps();
    }

    public static function crear(Request $r)
    {       
    	$alumno = new Alumno();
    	$alumno->nombres = $r->nombres;
    	$alumno->apellidos = $r->apellidos;
    	$alumno->nro_doc = $r->nro_doc;
    	$alumno->localidad = $r->localidad;            	
    	$alumno->email = $r->email;
    	$alumno->tel = $r->tel;
    	$alumno->cel = $r->cel;
    	$alumno->id_tipo_doc = $r->tipo_doc;
    	$alumno->id_provincia = $r->provincia;
    	$alumno->id_trabaja_en = $r->trabaja_en;
    	$alumno->id_funcion = $r->funcion;      
          
        $r->has('pais')?$alumno->id_pais = $r->pais:
        $alumno->establecimiento2 = null;

        $r->has('tipo_organismo')?
        $alumno->organismo1 = $r->tipo_organismo:
        $alumno->establecimiento2 = null;

        $r->has('organismo')?
        $alumno->organismo2 = $r->organismo:
        $alumno->establecimiento2 = null;

        $r->has('efectores')?
        $alumno->establecimiento1 = $r->efectores:
        $alumno->establecimiento2 = null;

        $r->has('establecimiento')?
        $alumno->establecimiento2 = $r->establecimiento:
        $alumno->establecimiento2 = null;
    	$alumno->save();
    }

    public function provincia()
    {
        return $this->hasOne('App\Provincia', 'id', 'id_provincia');
    }

    public function tipo_doc()
    {
        return $this->hasOne('App\TipoDoc', 'id', 'id_tipo_doc');
    }

    public function trabaja_en()
    {
        return $this->hasOne('App\Trabaja', 'id', 'id_trabaja_en');
    }

    public function funcion()
    {
        return $this->hasOne('App\Funcion', 'id', 'id_funcion');
    }
}
