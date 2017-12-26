<?php

namespace Tests\Controllers;

use App\Http\Controllers\CursosController;
use App\Models\Cursos\Curso;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Tests\TestCase;

class AccionesControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $controller;
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $this->controller = new CursosController();
        $this->model = new Curso();
    }

    public function accionesRequestProvider()
    {
        $requests = [];
        $filename = '/var/www/html/atyc/storage/logs/production/create-accion-2017-10-03.log';

        $f = fopen($filename, 'r');

        while (!feof($f)) {
            $line = fgets($f);
            $request_array = json_decode($line, true);
            $request = new Request($request_array);
            array_push($requests, [$request]);
        }
        return $requests;
    }

    /**
     * Return date with the correct format. "16/10/2013"
     *
     * @test
     * @return void
     */
    public function showCorrectDateFormat()
    {
        
        $curso = factory(\App\Models\Cursos\Curso::class)->create();
        $curso = $this->controller->show($curso->id_curso);
        $curso = json_decode($curso['curso'], true);
        $fecha = $curso['fecha'];

        $this->assertRegExp('/\d+\/\d+\/\d+/', $fecha, 'No tiene el formato correcto');
    }

    /**
     * Return
     * Depende de base de datos
     *
     * @dataProvider accionesRequestProvider
     * @testt
     * @return void
     */
    public function create(Request $request)
    {
        //$this->assertTrue($request->has('alumnos'), 'No tiene alumnos:'.json_encode($request->all()));
        $accion = $this->controller->store($request);
        $this->assertNotNull($accion, json_encode($accion));
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
