<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccionPauta extends Model
{
    protected $table = "acciones_pautas";

    protected $fillable = ['item', 'nombre', 'descripcion', 'anio_vigencia'];

    /**
     * Get las Pautas con esta action.
     */
    public function pautas()
    {
        return $this->hasMany('App\Models\Pac\Pauta');
    }
}
