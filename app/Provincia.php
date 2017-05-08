<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincias';

    public static function set($nombre)
    {
    	$ret = new Provincia();
    	$ret->nombre = $nombre;
    	$ret->save();
    }
}
