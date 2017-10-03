<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CursosControllerTest extends TestCase
{

    protected $controller;
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $this->controller = new App\Http\Controllers\CursosController();
        $this->model = new App\Models\Cursos\Curso();
    }

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function example()
    {
        $hardcoded = '[{"id_profesor":16,"nombres":"VALERIA","apellidos":"ZURITA","tipo_doc":"DNI","nro_doc":"28543915","pivot":{"id_curso":2455,"id_profesor":16,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":22,"nombres":"ROBERTO","apellidos":"DINARTE","tipo_doc":"DNI","nro_doc":"95182718","pivot":{"id_curso":2455,"id_profesor":22,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":36,"nombres":"AMALIA","apellidos":"TORRES","tipo_doc":"DNI","nro_doc":"18616223","pivot":{"id_curso":2455,"id_profesor":36,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":62,"nombres":"GUILLERMO","apellidos":"VILLANUEVA","tipo_doc":"DNI","nro_doc":"21634164","pivot":{"id_curso":2455,"id_profesor":62,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":195,"nombres":"MARCELA","apellidos":"TULA","tipo_doc":"DNI","nro_doc":"17345424","pivot":{"id_curso":2455,"id_profesor":195,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":241,"nombres":"JOSEFINA","apellidos":"MEDRANO","tipo_doc":"DNI","nro_doc":"22785540","pivot":{"id_curso":2455,"id_profesor":241,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":242,"nombres":"OSCAR","apellidos":"MULKI","tipo_doc":"DNI","nro_doc":"21310687","pivot":{"id_curso":2455,"id_profesor":242,"created_at":"2014-09-03 09:46:40","updated_at":"2014-09-03 09:46:40"}},{"id_profesor":269,"nombres":"DAIANA","apellidos":"SCHEISTEL","tipo_doc":"DNI","nro_doc":"30508412","pivot":{"id_curso":2455,"id_profesor":269,"created_at":"2014-09-09 12:31:43","updated_at":"2014-09-09 12:31:43"}},{"id_profesor":270,"nombres":"VERONICA","apellidos":"PEIRET","tipo_doc":"DNI","nro_doc":"25069517","pivot":{"id_curso":2455,"id_profesor":270,"created_at":"2014-09-09 12:31:43","updated_at":"2014-09-09 12:31:43"}},{"id_profesor":271,"nombres":"IGNACIO","apellidos":"NANNI","tipo_doc":"DNI","nro_doc":"28051182","pivot":{"id_curso":2455,"id_profesor":271,"created_at":"2014-09-09 12:31:43","updated_at":"2014-09-09 12:31:43"}}]';
        //$profesores = $controller->getProfesores(2455);
        //$this->assertTrue($profesores === $hardcoded);
    }

    /**
     * Return successfully created;
     *
     * 
     * @return void
     */
    public function createCurso()
    {
        $curso = [
            'nombre' => 'Capacitacion para ...',
            'id_provincia' => '23',
            'id_area_tematica' => '2',            
            'id_linea_estrategica' => '1',
            'fecha' => '16/10/2013',
            'duracion' => '12',
            'edicion' => '1'
        ];
        $r = $this->model->create($curso);

        $this->assertNotNull($r, 'message');
    }

    /**
     * Return date with the correct format. "16/10/2013"
     *
     * @test
     * @return void
     */
    public function showCorrectDateFormat()
    {
        $curso = $this->controller->show(4);
        $curso = json_decode($curso['curso'],true);
        $fecha = $curso['fecha'];

        $this->assertNotNull($fecha, 'Null');

        $this->assertRegExp('/\d+\/\d+\/\d+/', $fecha, 'No tiene el formato correcto');        
    } 

    /**
     * Return 
     * Depende de base de datos
     *  
     * @return void
     */
    public function getAlumnos()
    {
        $curso = $this->controller->getAlumnos(1);
        $this->assertEmpty($curso, json_encode($curso));
    }  
}
