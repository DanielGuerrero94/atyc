<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TallerSumarte extends Model
{
    protected $table = "cursos.talleres_sumarte";

    protected $fillable = ['nombre', 'obejetivo'];

    protected $primaryKey = 'id_taller_sumarte';

    /**
     * Get destinataraio del taller sumarte.
     */
    public function destinatarios()
    {
        return $this->belongsToMany('App\Funcion', 'cursos.talleres_sumarte_destinatarios', 'id_funcion', 'id_destinatario')->withTimestamps();
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
