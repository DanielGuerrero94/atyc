<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Pauta extends Model
{
    protected $table = "pac.pautas";

    protected $fillable = ['item', 'nombre', 'descripcion', 'id_accion_pauta'];
    protected $primaryKey = 'id_pauta';

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

    public function accionPauta()
    {
        return $this->hasOne('App\Models\Pac\AccionPauta', 'id_accion_pauta', 'id_accion_pauta');
    }
    /**
    *
    *
    *
    */
    public function crear(Request $r)
    {
        $this->item             = $r->item;
        $this->nombre           = $r->nombre;
        $this->descripcion      = $r->descripcion;
        $this->id_accion_pauta  = $r->id_accion_pauta;
        $this->save();
        return $this;
    }

    public function modificar(Request $r)
    {
        $this->item             = $r->item;
        $this->nombre           = $r->nombre;
        $this->descripcion      = $r->descripcion;
        $this->id_accion_pauta  = $r->id_accion_pauta;
        $this->save();
        return $this;
    }
}
