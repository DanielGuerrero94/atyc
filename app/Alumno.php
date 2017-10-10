<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = ['nombres', 'apellidos', 'id_tipo_documento', 'nro_doc', 'pais', 'id_genero', 'id_provincia', 'localidad', 'id_trabajo', 'tipo_organismo', 'organismo', 'tipo_convenio', 'efector', 'establecimiento', 'id_funcion']; */
    protected $fillable = ['nombres', 'apellidos', 'id_tipo_documento', 'nro_doc', 'id_genero', 'id_provincia', 'localidad', 'id_trabajo', 'id_funcion'];

    protected $hidden = ['pivot'];

    public function cursos()
    {
        return $this
        ->belongsToMany('App\Curso', 'cursos_alumnos', 'id_curso', 'id_alumno')
        ->withTimestamps();
    }

    public function provincia()
    {
        return $this->hasOne('App\Provincia', 'id_provincia', 'id_provincia');
    }

    public function tipoDocumento()
    {
        return $this
        ->hasOne('App\TipoDocumento', 'id_tipo_documento', 'id_tipo_documento');
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
        $alumno->organismo2 = $r->has('organismo')?$r->organismo:null;

        $alumno->establecimiento1 = $r->has('efector')?
        $r->efector:null;

        $alumno->establecimiento2 = $r->has('establecimiento')?
        $r->establecimiento:null;

        $alumno->save();
        return $alumno->id_alumno;
    }

    /**
     * Define si tiene que buscar solo para la provincia
     * de la que es el usuario o buscar para todas
     *
     */
    public function scopeSegunProvincia($query)
    {
        $id_provincia = Auth::user()->id_provincia;
        if ($id_provincia != 25) {
            return $query->where('alumnos.id_provincia', $id_provincia);
        }
    }

    /**
     * Si hace el join con la provincia o no
     *
     */
    public function scopeMostrarProvincia($query)
    {
        //Hasta que no corriga las views para que los datatable no tengan esta columna se le saca el if
        /*if (Auth::user()->id_provincia == 25) {*/
            return $query->leftJoin('sistema.provincias', 'alumnos.id_provincia', '=', 'sistema.provincias.id_provincia')
            ->select('sistema.provincias.nombre as provincia');
            /*}*/
    }
}
