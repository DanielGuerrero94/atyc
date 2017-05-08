<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class AreaTematica extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public static function table()
    {
    	return AreaTematica::all();
    }

    public function crear(Request $r)
    {
    	$this->nombre = $r->nombre;
    	$this->save();
    }

    public function modificar(Request $r)
    {
        $this->nombre = $r->nombre;
        $this->save();   
    }
}
