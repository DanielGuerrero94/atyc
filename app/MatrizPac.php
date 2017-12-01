<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizPac extends Model
{
    protected $table = "matriz_pacs";

    protected $fillable = ['trimestre_planificacion', 't1', 't2', 't3', 't4', 'consul_peatyc', 'observado', 'repeticiones', 'id_estado', 'id_provincia', 'id_tipo_action', 'id_sumarte_taller', 'id_action_capacitation'];

    protected $hidden = ['pivot'];

    /**
     * Get el estado de una pac.
     */
    public function estado()
    {
        return $this->belongsTo('App\Estado', 'id');
    }

    /**
     * Get la provincia de una pac.
     */
    public function provincia()
    {
        return $this->belongsTo('App\Provincia', 'id');
    }

    /**
     * Get el tipo_action de una pac.
     */
    public function tipoAction()
    {
        return $this->belongsTo('App\TipoAction', 'id');
    }

    /**
     * Get el sumarte_taller de una pac.
     */
    public function sumarteTaller()
    {
        return $this->belongsTo('App\SumarteTaller', 'id');
    }

    /**
     * Get la action_capacitation de una pac.
     */
    public function actionCapacitation()
    {
        return $this->belongsTo('App\ActionCapacitation', 'id');
    }

    /**
     * Los destinatarios de la pac.
     */
    public function destinatarios()
    {
        return $this->belongsToMany('App\Destinatario','matriz_pac_destinatario', 'id_destinatario', 'id_matriz_pac')->withTimestamps();
    }

    /**
     * Los caComponentes de la pac.
     */
    public function caComponentes()
    {
        return $this->belongsToMany('App\CaComponente', 'ca_componente_matriz_pac', 'id_matriz_pac', 'id_ca_componente')->withTimestamps();
    }

    /**
     * Las tematicas de la pac.
     */
    public function tematicas()
    {
        return $this->belongsToMany('App\Tematica', 'tematica_matriz_pac', 'id_matriz_pac', 'id_tematica')->withTimestamps();
    }

    /**
     * Las pautas de la pac.
     */
    public function pautas()
    {
        return $this->belongsToMany('App\Pauta', 'pauta_matriz_pac', 'id_matriz_pac', 'id_pauta')->withTimestamps();
    }
}