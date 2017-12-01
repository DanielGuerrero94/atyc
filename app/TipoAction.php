<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAction extends Model
{
    protected $table = "tipos_actions";

    protected $fillable = ['item', 'nombre', 'descripcion'];

    /**
     * Get las Pas con este tipoAction.
     */
    public function matrizPacs()
    {
        return $this->hasMany('App\MatrizPac');
    }
}
