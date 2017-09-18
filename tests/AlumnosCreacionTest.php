<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AlumnosCreacionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function creaAlumno()
    {
    	$json_alumno = json_decode('{"_token":"CHP1UvMw3tsWQJsUzwL5Suv0Aokg7rVTIW08pg6i","nombres":"Soledad","apellidos":"Carabajal","id_tipo_documento":"1","nro_doc":"27430495","id_genero":"2","localidad":"La Cocha","id_trabajo":"2","organismo":"Seleccionar","tipo_convenio":"on","efector":"06243","id_funcion":"5","email":"","tel":"","cel":"3865629677","id_provincia":"15"}',1);

    	$controller = new App\Http\Controllers\AlumnosController();

    	$request = new Illuminate\Http\Request($json_alumno);
    	$store = $controller->store($request);
    	$this->assertNull($store, 'message');
    }
}
