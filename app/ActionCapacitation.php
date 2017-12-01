<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionCapacitation extends Model
{
    protected $table = "actions_capacitations";

    protected $fillable = ['nombre_fantacia', 'descripcion'];

    /**
     * Get las Pacs con esta action.
     */
    public function matrizPacs()
    {
        return $this->hasMany('App\MatrizPac');
    }
}