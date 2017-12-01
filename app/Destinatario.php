<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destinatario extends Model
{
    protected $table = 'destinatarios';

    protected $fillable = ['nombre', 'descripcion'];

    protected $hidden = ['pivot'];

    /**
     * Las pacs de un destinatario.
     */
    public function matrizPacs()
    {
        return $this->belongsToMany('App\MatrizPac','destinatarios.matiz_pac_destinatario', 'id_matriz_pac', 'id_destinatario')->withTimestamps();
    }
}
