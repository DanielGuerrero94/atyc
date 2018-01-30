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

    public function setUp()
    {
        parent::setUp();
        $this->controller = $this->app->make(EncuestasController::class);
        $this->model = $this->app->make(Encuesta::class);
    }

    public function requestProvider()
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
     * @dataProvider requestProvider
     * @test
     */
    public function canStore(Request $request)
    {
        $id_encuesta = $this->controller->store($request)->id_encuesta;
        $this->assertTrue(is_numeric($id_encuesta));
    }

    /**
     * @dataProvider requestProvider
     * @test
     */
    public function tieneAccion(Request $request)
    {
        $id_encuesta = $this->controller->store($request)->id_encuesta;
        $encuesta = $this->model->with('curso')->findOrFail($id_encuesta);
        $this->assertTrue(is_numeric($encuesta->curso->id_curso));
    }

    /**
     * @dataProvider requestProvider
     * @test
     */
    public function tienePregunta(Request $request)
    {
        $id_encuesta = $this->controller->store($request)->id_encuesta;
        $encuesta = $this->model->with('pregunta')->findOrFail($id_encuesta);
        $this->assertTrue(is_numeric($encuesta->pregunta->id_pregunta));
    }

    /**
     * @dataProvider requestProvider
     * @test
     */
    public function tieneRespuesta(Request $request)
    {
        $id_encuesta = $this->controller->store($request)->id_encuesta;
        $encuesta = $this->model->with('respuesta')->findOrFail($id_encuesta);
        $this->assertTrue(is_numeric($encuesta->respuesta->id_respuesta));
    }
}
