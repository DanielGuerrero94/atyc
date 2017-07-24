<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CursosControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function example()
    {
        $hardcoded = '[{"id_profesor":16,"nombres":"VALERIA","apellidos":"ZURITA","tipo_doc":"DNI","nro_doc":"28543915","pivot":{"id_curso":2455,"id_profesor":16,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":22,"nombres":"ROBERTO","apellidos":"DINARTE","tipo_doc":"DNI","nro_doc":"95182718","pivot":{"id_curso":2455,"id_profesor":22,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":36,"nombres":"AMALIA","apellidos":"TORRES","tipo_doc":"DNI","nro_doc":"18616223","pivot":{"id_curso":2455,"id_profesor":36,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":62,"nombres":"GUILLERMO","apellidos":"VILLANUEVA","tipo_doc":"DNI","nro_doc":"21634164","pivot":{"id_curso":2455,"id_profesor":62,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":195,"nombres":"MARCELA","apellidos":"TULA","tipo_doc":"DNI","nro_doc":"17345424","pivot":{"id_curso":2455,"id_profesor":195,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":241,"nombres":"JOSEFINA","apellidos":"MEDRANO","tipo_doc":"DNI","nro_doc":"22785540","pivot":{"id_curso":2455,"id_profesor":241,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":242,"nombres":"OSCAR","apellidos":"MULKI","tipo_doc":"DNI","nro_doc":"21310687","pivot":{"id_curso":2455,"id_profesor":242,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":269,"nombres":"DAIANA","apellidos":"SCHEISTEL","tipo_doc":"DNI","nro_doc":"30508412","pivot":{"id_curso":2455,"id_profesor":269,"created_at":"2014-09-09 12:31:43","updated_at":"2014-09-09 12:31:43"}},{"id_profesor":270,"nombres":"VERONICA","apellidos":"PEIRET","tipo_doc":"DNI","nro_doc":"25069517","pivot":{"id_curso":2455,"id_profesor":270,"created_at":"2014-09-09 12:31:43","updated_at":"2014-09-09 12:31:43"}},{"id_profesor":271,"nombres":"IGNACIO","apellidos":"NANNI","tipo_doc":"DNI","nro_doc":"28051182","pivot":{"id_curso":2455,"id_profesor":271,"created_at":"2014-09-09 12:31:43","updated_at":"2014-09-09 12:31:43"}}]';
        $controller = new App\Http\Controllers\CursosController();
        //$profesores = $controller->getProfesores(2455);
        //$this->assertTrue($profesores === $hardcoded);
    }
}
