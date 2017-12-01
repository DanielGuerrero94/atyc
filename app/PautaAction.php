<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PautaAction extends Model
{
    protected $table = "pautas_actions";

    protected $fillable = ['item', 'nombre', 'descripcion', 'anio_vigencia'];

    /**
     * Get las Pautas con esta action.
     */
    public function pautas()
    {
        return $this->hasMany('App\Pauta');
    }
}
