<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pac extends Model
{
    protected $table = "pac.pac";

    protected $fillable = ['trimestre_planificacion', 't1', 't2', 't3', 't4', 'consul_peatyc', 'observado', 'repeticiones', 'id_curso'];


    /**
     * Get la PautaAction de una Pauta.
     */
    public function curso()
    {
        return $this->hasOne('App\Models\Cursos\Curso', 'id_curso', 'id_curso');
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
