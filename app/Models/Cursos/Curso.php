<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Auth;

class Curso extends Model
{
    
    use SoftDeletes;

    protected $table = "cursos.cursos";

    protected $dates = ['deleted_at'];
    
    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_curso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','id_provincia','id_area_tematica',
    'id_linea_estrategica','fecha','duracion','edicion'];

    protected $hidden = ['pivot'];

    public function profesores()
    {
        return $this->belongsToMany(
            'App\Profesor',
            'cursos.cursos_profesores',
            'id_curso',
            'id_profesor'
        )
            ->withTimestamps();
    }

    public function alumnos()
    {
        return $this->belongsToMany(
            'App\Alumno',
            'cursos.cursos_alumnos',
            'id_curso',
            'id_alumno'
        )
            ->withTimestamps();
    }

    public function provincia()
    {
        return $this->hasOne('App\Provincia', 'id_provincia', 'id_provincia');
    }

    public function areaTematica()
    {
        return $this->hasOne(
            'App\Models\Cursos\AreaTematica',
            'id_area_tematica',
            'id_area_tematica'
        );
    }

    public function lineaEstrategica()
    {
        return $this->hasOne(
            'App\Models\Cursos\LineaEstrategica',
            'id_linea_estrategica',
            'id_linea_estrategica'
        );
    }

    public function crear(Request $r)
    {
        $this->nombre = $r->nombre;
        $this->id_provincia = $r->id_provincia;
        $this->id_area_tematica = $r->id_area_tematica;
        $this->id_linea_estrategica = $r->id_linea_estrategica;
        $this->fecha = $r->fecha;
        $this->duracion = $r->duracion;

        /*Tengo que buscar cuantas ocurrencias hay del nombre de curso
        para saber que edicion es,
        podria ser un trigger en insert*/

        $edicion = Curso::where('nombre', '=', $r->nombre)->count();

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
        ->join(
            'cursos.cursos_alumnos',
            'cursos.cursos_alumnos.id_curso',
            '=',
            'cursos.cursos.id_curso'
        )
        ->join(
            'alumnos.alumnos',
            'alumnos.alumnos.id_alumno',
            '=',
            'cursos.cursos_alumnos.id_alumno'
        )
        ->select(
            'cursos.cursos.id_curso',
            'cursos.cursos.nombre',
            'cursos.cursos.fecha',
            DB::raw('count(*) as alumnos')
        )
        ->where('alumnos.alumnos.establecimiento1', '=', $cuie)
        ->groupBy(
            'cursos.cursos.id_curso',
            'cursos.cursos.nombre',
            'cursos.cursos.fecha'
        )
        ->orderBy('cursos.cursos.fecha', 'desc')
        ->get();
    }

    public function scopeSegunProvincia($query)
    {
        $id_provincia = Auth::user()->id_provincia;
        if ($id_provincia != 25) {
            return $query->where('cursos.id_provincia', $id_provincia);
        }
    }
}
