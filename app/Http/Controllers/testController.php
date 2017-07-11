<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Mostrar\Mostrar;
use DB;
use Log;

class testController extends Mostrar
{

	public function __construct()
    {
        $this->setVista('formulario');
        $this->setCampos(array('id','funcion','nombres'));
    }

	public function hello()
	{
		logger('Hello');
	}
}
