<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TallerSumarte extends Model
{
    protected $table = "talleres_sumarte";

    protected $fillable = ['nombre', 'obejetivo'];

    /**
     * Get las Pacs con este taller.
     */
    public function cursos()
    {
        return $this->belongsToMany('App\Models\Cursos\Curso', 'cursos.cursos_talleres_sumarte', 'id_curso', 'id_taller_sumarte')->withTimestamps();
    }

    /**
    *
    *
    *
    */
    public function crear(Request $r)
    {
        $this->nombre = $r->nombre;
        $this->obejetivo = $r->obejetivo;
        $this->save();
        return $this;
    }
}
