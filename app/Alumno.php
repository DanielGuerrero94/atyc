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

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alumnos.alumnos';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_alumno';

    public function cursos()
    {   
        return $this->belongsToMany('App\Curso','cursos_alumnos','id_cursos','id_alumnos')->withTimestamps();
    }

    public function provincia()
    {
        return $this->hasOne('App\Provincia', 'id_provincia', 'id_provincia');
    }

    public function tipo_documento()
    {
        return $this->hasOne('App\TipoDocumento', 'id_tipo_documento', 'id_tipo_documento');
    }

    public function pais()
    {
        return $this->hasOne('App\Pais', 'id_pais', 'id_pais');
    }

    public function trabajo()
    {
        return $this->hasOne('App\Trabajo', 'id_trabajo', 'id_trabajo');
    }

    public function funcion()
    {
        return $this->hasOne('App\Funcion', 'id_funcion', 'id_funcion');
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
    	$alumno->id_tipo_documento = $r->tipo_doc;
    	$alumno->id_provincia = $r->provincia;
    	$alumno->id_trabajo = $r->trabaja_en;
    	$alumno->id_funcion = $r->funcion;      
          
        $alumno->id_pais = $r->has('pais')?$r->pais:null;
        $alumno->organismo1 = $r->has('tipo_organismo')?$r->tipo_organismo:null;
        $alumno->organismo2 = $r->has('organismo')?$r->organismo:null;
        $alumno->establecimiento1 = $r->has('efectores')?$r->efectores:null;
        $alumno->establecimiento2 = $r->has('establecimiento')?$r->establecimiento:null;

    	$alumno->save();
    }
}
