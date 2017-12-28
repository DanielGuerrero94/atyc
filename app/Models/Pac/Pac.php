<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class Pac extends Model
{
    protected $table = "pac.pac";

    protected $fillable = ['trimestre_planificacion', 't1', 't2', 't3', 't4', 'consul_peatyc', 'observado'];

    protected $primaryKey = 'id_pac';

    /**
     * Acciones planificadas.
     */
    public function acciones()
    {
        return $this->belongsToMany('App\Models\Cursos\Curso', 'pac.pacs_cursos', 'id_curso', 'id_pac');
    }

    /**
     * Componentes del compromiso anual.
     */
    public function componentesCa()
    {
        return $this->hasMany('App\Models\Pac\ComponenteCa', 'pac.pacs_componentes_ca', 'id_componente_ca', 'id_pac');
    }

    /**
     * Destinatarios de las acciones planificadas.
     */
    public function destinatarios()
    {
        return $this->belongsToMany('App\Funcion', 'pac.pacs_destinatarios', 'id_pac', 'id_funcion');
    }

    /**
     * Ficha tecnica.
     */
    public function ficha_tecnica()
    {
        return $this->hasOne('App\Material', 'id_material', 'id_ficha_tecnica');
    }    

    public function crear(Request $r)
    {
        $this->trimestre_planificacion = $r->trimestre_planificacion;
        $this->t1 = $r->t1;
        $this->t2 = $r->t2;
        $this->t3 = $r->t3;
        $this->t4 = $r->t4;
        $this->consul_peatyc = $r->consul_peatyc;
        $this->observado = $r->observado;
        $this->save();
        return $this;
    }
}
