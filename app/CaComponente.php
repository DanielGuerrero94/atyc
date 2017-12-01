<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaComponente extends Model
{
    protected $table = "ca_componentes";

    protected $fillable = ['nombre', 'anio_vigencia'];

    /**
     * Las pacs de un caComponente.
     */
    public function matrizPacs()
    {
        return $this->belongsToMany('App\MatrizPac', 'ca_componente_matriz_pac', 'id_matriz_pac', 'id_ca_componente')->withTimestamps();
    }	
}
