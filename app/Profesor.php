<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;
use App\Alumno;

class Profesor extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sistema.profesores';    
   
    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_profesor';

    public function cursos()
    { 
        return $this->belongsToMany('App\Curso', 'cursos.cursos_profesores', 'id_cursos', 'id_profesores')->withTimestamps();
    }

    public function tipo_documento()
    {
        return $this->hasOne('App\TipoDocumento', 'id_tipo_documento', 'id_tipo_documento');
    }

    public function crear(Request $r)
    {
        $this->nombres = $r->nombres;
        $this->apellidos = $r->apellidos;

        $id_tipo_doc = $r->id_tipo_doc;

        $this->id_tipo_doc = $id_tipo_doc;

        if ($id_tipo_doc === '6' || $id_tipo_doc === '5') {
            $this->id_pais = $r->pais;
        }

        $this->nro_doc = $r->nro_doc;
        $this->email = $r->email;
        $this->cel = $r->cel;
        $this->tel = $r->tel;
        $this->save();
        return $this;
    }

    public function modificar(Request $r)
    {
        $this->nombres = $r->nombres;
        $this->apellidos = $r->apellidos;

        $id_tipo_doc = $r->id_tipo_doc;

        $this->id_tipo_doc = $id_tipo_doc;

        if ($id_tipo_doc === '6' || $id_tipo_doc === '5') {
            $this->id_pais = $r->pais;
        }

        $this->nro_doc = $r->nro_doc;
        $this->email = $r->email;
        $this->cel = $r->cel;
        $this->tel = $r->tel;
        $this->save();
        return $this;
    }
}
