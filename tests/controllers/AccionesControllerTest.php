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

    public function fakerRequestProvider()
    {
        return factory(Curso::class, 5)->make()->map(function ($model) {
            return new Request($model->toArray());
        });
    }

    /**
     * Return date with the correct format. "16/10/2013"
     *
     * @test
     * @return void
     */
    public function showCorrectDateFormat()
    {
        $curso = factory(Curso::class)->states('completo')->create();
        $curso = $this->controller->show($curso->id_curso);
        $curso = json_decode($curso['curso'], true);
        $fecha = $curso['fecha'];

        $this->assertRegExp('/\d+\/\d+\/\d+/', $fecha, 'No tiene el formato correcto');
    }

    /**
     * Return
     * Depende de base de datos
     *
     * @test
     * @return void
     */
    public function create()
    {
        $requests = factory(Curso::class, 2)->states('completo')->make()->map(function ($model) {
            return new Request($model->toArray());
        });
        foreach ($requests as $request) {
            $accion = $this->controller->store($request);
            $this->assertNotNull($accion, json_encode($accion));
        }
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
        $this->assertEmpty($curso, $curso);
    }

    /**
     * Permite crear una accion sin fecha de inicio para la pac
     *
     * @test
     * @return void
     */
    public function newCreate()
    {
        $curso = factory(Curso::class)->create();
        $this->assertTrue(is_numeric($curso->id_curso));
    }
}
