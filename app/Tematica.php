<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tematica extends Model
{
    protected $table = "tematicas";

    protected $fillable = ['nombre', 'descripcion'];

    /**
     * Las pacs de una tematica.
     */
    public function matrizPacs()
    {
        return $this->belongsToMany('App\MatrizPac')->withTimestamps();
    }
}
