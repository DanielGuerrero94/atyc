<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = "estados";

    protected $fillable = ['nombre'];

    /**
     * Get las Pacs con ese estado.
     */
    public function matrizPacs()
    {
        return $this->hasMany('App\MatrizPac');
    }
}
