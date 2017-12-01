<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SumarteTaller extends Model
{
    protected $table = "sumarte_tallers";

    protected $fillable = ['nombre', 'obejetivo'];

    /**
     * Get las Pacs con este taller.
     */
    public function matrizPacs()
    {
        return $this->hasMany('App\MatrizPac');
    }
}
