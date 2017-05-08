<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use Datatables;

class efectoresController extends Controller
{
	public function query($query)
    {
    	return DB::connection('efectores')->select($query);
    }

    public function get()
    {
    	return view('efectores');
    }

    public function getTabla()
    {        
        //Las columnas que tengo que mostrar son estas: nombre provincia,codigo siisa,cuie ,nombre,denominacion legal,domicilio,departamento,localida,codgio postal,ciudad


        //Me faltan traer columnas pero porque no se de donde salen, son departamento y ciudad 
        //codigo_provinicial esta asi en la tabla
        $query = "SELECT GP.descripcion AS \"provincia\",siisa,cuie,nombre,denominacion_legal,domicilio,GD.nombre_departamento AS \"departamento\", GL.nombre_localidad AS \"localidad\",codigo_postal,DG.ciudad FROM efectores.efectores E 
        INNER JOIN efectores.datos_geograficos DG ON DG.id_efector = E.id_efector
        LEFT JOIN geo.provincias GP ON GP.id_provincia = DG.id_provincia
        LEFT JOIN geo.departamentos GD ON GD.id = DG.id_departamento
        LEFT JOIN geo.localidades GL ON GL.id = DG.id_localidad";
        $returns = $this->query($query);
        $returns = collect($returns);
        Log::info(json_encode($returns));
        return Datatables::of($returns)->make(true);   
    }

    public function getTripleTypeahead()
    {
        $ret = array(
        'status' => true,
        'error' => null,
        'data' => array(
        'nombres' => $this->getNombres(),
        'cuies' => $this->getCuies(),
        'siisas' => $this->getSiisas()
        )
        );

        return json_encode($ret);
    }

    public function getNombres()
    {   
        $query = "SELECT nombre FROM efectores ORDER BY nombre";
        $nombres = $this->query($query);
        $nombres = collect($nombres);

        $arrayMapeado = $nombres->map(function($item,$key)
        {
            return $item->nombre;
        });

        return $arrayMapeado;        
    }

    public function getCuies()
    {   
        $query = "SELECT cuie FROM efectores ORDER BY cuie";
        $cuies = $this->query($query);
        $cuies = collect($cuies);

        $arrayMapeado = $cuies->map(function($item,$key)
        {
            return $item->cuie;
        });

        return $arrayMapeado;
    }

    public function getSiisas()
    {   
        $query = "SELECT siisa FROM efectores ORDER BY siisa";
        $siisas = $this->query($query);
        $siisas = collect($siisas);

        $arrayMapeado = $siisas->map(function($item,$key)
        {
            return $item->siisa;
        });

        return $arrayMapeado;
    }
}
