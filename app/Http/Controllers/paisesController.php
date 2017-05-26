<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pais;
use DB;

class paisesController extends Controller
{
    public function getNombres()
    {
    	$paises = collect(Pais::all());

    	$arrayMapeado = $paises->map(function($item,$key)
		{
			return $item->nombre;
		});

		$ret = array(
			'status' => true,
			'error' => null,
			'data' => array(
				'info' => $arrayMapeado
				)
			);

		return json_encode($ret);
    }

    public function getIdByNombre($nombre)
    {	
		$id_pais = DB::table('paises')->select('nombre')->get();
    	return $id_pais;
    }

    public function getNombreById($id)
    {
		$nombre_pais = Pais::find($id)->nombre;
    	return $nombre_pais;	
    }
}
