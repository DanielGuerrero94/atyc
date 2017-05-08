<?php

namespace App\Http\Controllers\Mostrar;

use App\Http\Controllers\Controller;
use DB;
use Log;

class Mostrar extends Controller implements Mostrable
{
	private $vista;
	private $campos;

	public function getVista()
	{
		return $this->vista;
	}

	public function setVista($nombre)
	{
		$this->vista = $nombre;
	}

	public function getCampos()
	{
		return $this->campos;
	}

	public function setCampos($nombre)
	{
		$this->campos = $nombre;
	}

	public function filtros(){

		$query = "SELECT column_name
		FROM information_schema.columns
		WHERE table_schema = 'g_plannacer'
		AND table_name   = 'alumnos';";

		$ret =  collect(DB::connection('eLearning')->select($query));

		$filtered = $ret->filter(function ($value,$key)
		{
			foreach ($value as $column => $name) {
				return in_array($name,$this->campos);
			} 
		})->map(function ($value,$key)
		{
            foreach ($value as $column => &$name) {//Le paso el puntero
            	$name = ucfirst($name);
            	return $value;
            }    
        });
		Log::info($filtered);
		return view($this->vista,['columnas' => $filtered]);
	}	

	public function abm(){}

	public function datatable(){}

	public function dashboard(){}
}
