<?php

namespace App\Models\Pac;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pac extends Model
{
    protected $table = "pac.pac";

    protected $dates = ['deleted_at'];
    
    protected $fillable = ['nombre', 't1', 't2', 't3', 't4', 'observado', 'id_provincia'];

    protected $primaryKey = 'id_pac';

    /**
     * Acciones planificadas.
     */
/*    public function acciones()
    {
        return $this->belongsToMany('App\Models\Cursos\Curso', 'pac.pacs_cursos', 'id_curso', 'id_pac');
    }*/

    /**
     * Las pacs de una pauta.
     */
    public function pautas()
    {
        return $this->belongsToMany('App\Models\Pac\Pauta', 'pac.pacs_pautas', 'id_pac', 'id_pauta')->withTimestamps();
    }

    /**
     * Componentes del compromiso anual.
     */
    public function componentesCa()
    {
        return $this->belongsToMany('App\Models\Pac\ComponenteCa', 'pac.pacs_componentes_ca', 'id_pac', 'id_componente_ca')->withTimestamps();
    }

    /**
     * Destinatarios de las acciones planificadas.
     */
    public function destinatarios()
    {
        return $this->belongsToMany('App\Funcion', 'pac.pacs_destinatarios', 'id_pac', 'id_funcion')->withTimestamps();
    }

    /**
     * Ficha tecnica.
     */
    public function ficha_tecnica()
    {
        return $this->hasOne('App\Material', 'id_material', 'id_ficha_tecnica');
    }    
    
    /**
     * Areas tematicas.
     */
/*    public function areasTematicas()
    {
        return $this->belongsToMany('App\Models\Cursos\AreaTematica', 'pac.pacs_areas_tematicas', 'id_area_tematica', 'id_pac');
    }*/

    public function crear(Request $r)
    {
        $id_provincia = Auth::user()->id_provincia;
        $this->nombre = $r->nombre;
        $this->t1 = $r->t1;
        $this->t2 = $r->t2;
        $this->t3 = $r->t3;
        $this->t4 = $r->t4;
        $this->observado = $r->observado;
        $this->id_provincia = $id_provincia;
        $this->save();
        return $this;
    }
}
