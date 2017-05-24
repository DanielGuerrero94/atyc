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

	/**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_linea_estrategica';

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
}
