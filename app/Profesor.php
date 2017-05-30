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
        $this->id_tipo_documento = $r->id_tipo_documento;

        /*if ($id_tipo_documento === '6' || $id_tipo_documento === '5') {
            $this->id_pais = $r->pais;
        }*/

        if ($this->esExtranjero($r)) {
            logger('Es extranjero');
            $id_pais = Pais::select('id_pais')->where('nombre','=',$r->pais)->get('id_pais')->first();
            logger(json_encode($id_pais['id_pais']));
            $this->id_pais = $id_pais['id_pais'];
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

        $id_tipo_documento = $r->id_tipo_documento;

        $this->id_tipo_documento = $id_tipo_documento;

        if ($this->esExtranjero($r)) {
            $this->id_pais = $r->pais;
        }

        $this->nro_doc = $r->nro_doc;
        $this->email = $r->email;
        $this->cel = $r->cel;
        $this->tel = $r->tel;
        $this->save();
        return $this;
    }

    private function esExtranjero(Request $request)
    {
        return $request->has('pais') && ($request->id_tipo_documento == 5 || $request->id_tipo_documento == 6);
    }
}
