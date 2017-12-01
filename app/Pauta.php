<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pauta extends Model
{
    protected $table = "pautas";

    protected $fillable = ['nombre', 'descripcion', 'id_pauta_action'];

    /**
     * Las pacs de una pauta.
     */
    public function matrizPacs()
    {
        return $this->belongsToMany('App\MatrizPac', 'pauta_matriz_pac', 'id_matriz_pac', 'id_pauta')->withTimestamps();
    }

    /**
     * Get la PautaAction de una Pauta.
     */
    public function pautaAction()
    {
        return $this->belongsTo('App\PautaAction');
    }
}
