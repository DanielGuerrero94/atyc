<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pauta extends Model
{
    protected $table = "pac.pautas";

    protected $fillable = ['nombre', 'descripcion', 'id_accion_pauta'];

    /**
     * Las pacs de una pauta.
     */
    public function cursos()
    {
        return $this->belongsToMany('App\Models\Cursos\Curso', 'cursos.cursos_pautas', 'id_curso', 'id_pauta')->withTimestamps();
    }

    /**
     * Get la PautaAction de una Pauta.
     */
    public function accionesPautas()
    {
        return $this->belongsTo('App\Models\Pac\AccionPauta');
    }

    /**
    *
    *
    *
    */
    public function crear(Request $r)
    {
        $this->nombre = $r->nombre;
        $this->descripcion = $r->descripcion;
        $this->id_accion_pauta = $r->id_accion_pauta;
        $this->save();
        return $this;
    }
}
