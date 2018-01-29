<?php

namespace Tests\Controllers;

use App\Http\Controllers\Encuestas\EncuestasController;
use App\Models\Encuestas\Encuesta;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Tests\TestCase;

class EncuestasControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $model;
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->model = new Encuesta();
        $this->controller = new EncuestasController();
    }

    public function encuestaProvider()
    {
        $this->refreshApplication();
        return factory(Encuesta::class, 3)
        ->make()
        ->map(function ($i) {
            return [new Request($i->toArray())];
        })
        ->all();
    }

    /**
     * @dataProvider encuestaProvider
     * @test
     */
    public function canStore(Request $request)
    {
        $id_encuesta = $this->controller->store($request);
        $this->assertTrue(is_numeric($id_encuesta));
    }

    /**
     * @dataProvider encuestaProvider
     * @test
     */
    public function tieneAccion(Request $request)
    {
        $id_encuesta = $this->controller->store($request);
        $encuesta = $this->model->with('curso')->findOrFail($id_encuesta);
        $this->assertTrue(is_numeric($encuesta->curso->id_curso));
    }

    /**
     * @dataProvider encuestaProvider
     * @test
     */
    public function tienePregunta(Request $request)
    {
        $id_encuesta = $this->controller->store($request);
        $encuesta = $this->model->with('pregunta')->findOrFail($id_encuesta);
        $this->assertTrue(is_numeric($encuesta->pregunta->id_pregunta));
    }

    /**
     * @dataProvider encuestaProvider
     * @test
     */
    public function tieneRespuesta(Request $request)
    {
        $id_encuesta = $this->controller->store($request);
        $encuesta = $this->model->with('respuesta')->findOrFail($id_encuesta);
        $this->assertTrue(is_numeric($encuesta->respuesta->id_respuesta));
    }
}
