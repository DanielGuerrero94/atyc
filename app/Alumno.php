<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Alumno extends Model
{
    use SoftDeletes;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombres', 'apellidos', 'id_tipo_documento', 'nro_doc', 'id_genero', 'id_provincia',
    'localidad', 'id_trabajo', 'id_funcion'];

    /**
     * Nombre de la columna que define el soft delete del trait.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are hidden in the response.
     *
     * @var array
     */
    protected $hidden = ['pivot'];

    /**
     * Obtiene las acciones en las que participo.
     */
    public function cursos()
    {
        return $this
        ->belongsToMany('App\Models\Cursos\Curso', 'cursos.cursos_alumnos', 'id_alumno', 'id_curso')
        ->withTimestamps();
    }
    
    /**
     * Obtiene la provincia asocida.
     */
    public function provincia()
    {
        return $this->hasOne('App\Provincia', 'id_provincia', 'id_provincia');
    }

    /**
     * Obtiene el tipo de documento.
     */
    public function tipoDocumento()
    {
        return $this
        ->hasOne('App\TipoDocumento', 'id_tipo_documento', 'id_tipo_documento');
    }

    /**
     * Obtiene el pais de origen en caso de ser extranjero.
     */
    public function pais()
    {
        return $this->hasOne('App\Pais', 'id_pais', 'id_pais');
    }

    /**
     * Obtiene el tipo de trabajo.
     */
    public function trabajo()
    {
        return $this->hasOne('App\Trabajo', 'id_trabajo', 'id_trabajo');
    }

    /**
     * Obtiene la funcion o el rol que cumple.
     */
    public function funcion()
    {
        return $this->hasOne('App\Funcion', 'id_funcion', 'id_funcion');
    }

    /**
     * Obtiene el genero.
     */
    public function genero()
    {
        return $this->hasOne('App\Genero', 'id_genero', 'id_genero');
    }

    public static function crear(Request $r)
    {
        $alumno = new Alumno();

        $alumno->nombres = ucwords($r->nombres);
        $alumno->apellidos = ucwords($r->apellidos);
        $alumno->nro_doc = $r->nro_doc;
        $alumno->localidad = ucwords($r->localidad);
        $alumno->email = $r->email;
        $alumno->tel = $r->tel;
        $alumno->cel = $r->cel;
        $alumno->id_tipo_documento = $r->id_tipo_documento;
        $alumno->id_provincia = $r->id_provincia;
        $alumno->id_trabajo = $r->id_trabajo;
        $alumno->id_funcion = $r->id_funcion;
        $alumno->id_genero = $r->id_genero;
        $alumno->id_convenio = $r->has('id_convenio')?$r->id_convenio:null;

        $alumno->id_pais = $r->has('pais')?$r->pais:null;
        $alumno->organismo1 = $r->has('tipo_organismo')?$r->tipo_organismo:null;
        $alumno->organismo2 = $r->has('nombre_organismo')?$r->nombre_organismo:null;

        $alumno->establecimiento1 = $r->has('efector')?
        $r->efector:null;

        $alumno->establecimiento2 = $r->has('establecimiento')?
        $r->establecimiento:null;

        $alumno->save();
        return $alumno;
    }

    /**
     * Obtiene los nombres del participante en title case.
     *
     * @param  string  $value
     * @return string
     */
    public function getNombresAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Obtiene los apellidos del participante en title case.
     *
     * @param  string  $value
     * @return string
     */
    public function getApellidosAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Obtiene la localidad del participante en title case.
     *
     * @param  string  $value
     * @return string
     */
    public function getLocalidadAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Define si tiene que buscar solo para la provincia
     * de la que es el usuario o buscar para todas.
     * Dependiendo de la provincia del usuario para mas adelante dependiendo del rol
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSegunProvincia($query)
    {
        $id_provincia = Auth::user()->id_provincia;
        if ($id_provincia != 25) {
            return $query->where('alumnos.id_provincia', $id_provincia);
        }
        return $query;
    }
}
