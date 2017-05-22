<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class LineaEstrategica extends Model
{
	use SoftDeletes;

	protected $table = 'cursos.lineas_estrategicas';

	protected $dates = ['deleted_at'];

	public static function table()
	{
		return LineaEstrategica::all();
	}

	public function crear(Request $r)
	{
		$this->nombre = $r->nombre;
		$this->numero = $r->numero;
		$this->save();
	}

	public function modificar(Request $r)
	{
		$this->nombre = $r->nombre;
		$this->numero = $r->numero;
		$this->save();		
	}

	public function darBaja(Request $r)
	{
		
	}	
}
