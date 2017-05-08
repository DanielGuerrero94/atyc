<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pais;
use Log;
use DB;

class paisesController extends Controller
{
    public function getNombres()
    {
    	//No hay repetidos asi que no tengo que hacer un distinct
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
		Log::info('Pais:'.json_encode($nombre));    	
		$id_pais = DB::table('paises')->select('nombre')->get();
		/*$id_pais = Pais::where('nombre','=',$nombre)->get('id');*/
    	Log::info('Pais:'.json_encode($id_pais));
    	return $id_pais;
    }

    public function getNombreById($id)
    {
		$nombre_pais = Pais::find($id)->nombre;
    	return $nombre_pais;	
    }
}
