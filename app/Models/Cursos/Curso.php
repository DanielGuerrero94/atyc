<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Curso extends Model
{
    
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "cursos.cursos";

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_curso';

    /**
     * The model's attributes.
     *
     * @var array
     */
    // protected $attributes = ['tematica'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = ['tematica'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','id_provincia',
    'id_linea_estrategica','fecha','duracion','edicion','id_estado','id_area_tematica'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['pivot'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


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

    //Retro compatibilidad rapida
    public function areaTematica()
    {
        return $this->hasOne(
            'App\Models\Cursos\AreaTematica',
            'id_area_tematica',
            'id_area_tematica'
        );
    }

    /**
     * Areas tematicas.
     */
    public function areasTematicas()
    {
        return $this->belongsToMany(
            'App\Models\Cursos\AreaTematica',
            'cursos.cursos_areas_tematicas',
            'id_curso',
            'id_area_tematica'
        )->withTimestamps();
    }

    public function provincia()
    {
        return $this->hasOne('App\Provincia', 'id_provincia', 'id_provincia');
    }

    public function lineaEstrategica()
    {
        return $this->hasOne(
            'App\Models\Cursos\LineaEstrategica',
            'id_linea_estrategica',
            'id_linea_estrategica'
        );
    }

    public function getByCuie($cuie)
    {
        return $this->query()
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
            'alumnos.alumnos.establecimiento1',
            'cursos.cursos.id_curso',
            'cursos.cursos.nombre',
            'cursos.cursos.fecha'
        )
        ->selectRaw('count(*) as alumnos')
        ->where('alumnos.alumnos.establecimiento1', $cuie)
        ->groupBy(
            'alumnos.alumnos.establecimiento1',
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

    public function getFechaAttribute($value)
    {
        return implode('/', array_reverse(explode("-", $value)));
    }

    /**
     * Retorna la duracion en horas.
     *
     * @var string
     */
    public function getDuracionAttribute($value)
    {
        return $value . " hs";
    }
}
