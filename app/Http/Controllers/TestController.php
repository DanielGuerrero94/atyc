<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Mostrar\Mostrar;
use DB;
use Log;

class TestController extends Mostrar
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

    public static function requestStore()
    {
        return json_decode('{"nombres":"test","apellidos":"testing","nro_doc":"12345678","email":"testing@testing.com","tel":"12345678","cel":"12345678","id_tipo_documento":"1","id_tipo_docente":"5"}', true);
    }

    public function session(Request $request)
    {
        return $request->session()->all();
    }

    public function sessionPut(Request $request)
    {
        return $request->session()->put('asd', 'aaaaaaaaaaaa');
    }
}
