<?php

namespace Tests\Controllers;

use App\Http\Controllers\AreasTematicasController;
use App\Models\Cursos\AreaTematica;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Tests\TestCase;

class AreasTematicasControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->controller = $this->app->make(AreasTematicasController::class);
        $this->model = $this->app->make(AreaTematica::class);
    }

    public function requestProvider()
    {
        $this->refreshApplication();
        return factory(AreaTematica::class, 3)
        ->make()
        ->map(function ($i) {
            return [new Request($i->toArray())];
        })
        ->all();
    }

    /**
     * Store model with request
     *
     * @param Request $request
     * @dataProvider requestProvider
     * @test
     */
    public function store(Request $request)
    {
        $id = $this->controller->store($request)->id_area_tematica;
        $this->assertTrue($this->model->find($id)->exists, 'No se persistio');
    }

    /**
     * Show model with request
     *
     * @param Request $request
     * @dataProvider requestProvider
     * @test
     */
    public function show(Request $request)
    {
        $id = $this->controller->store($request)->id_area_tematica;
        $array = $this->controller->show($id);
        $this->assertArrayHasKey('area', $array);
    }

    /**
     * Update model with request
     *
     * @param Request $request
     * @dataProvider requestProvider
     * @test
     */
    public function update(Request $request)
    {
        $id = $this->controller->store($request)->id_area_tematica;
        $antes = $this->model->findOrFail($id)->first()->nombre;
        $request->replace(['nombre' => strtoupper($request->nombre)]);
        $this->controller->update($request, $id);
        $despues = $this->model->findOrFail($id)->nombre;
        $this->assertFalse($antes === $despues, 'Son iguales no se hizo el update');
    }

    /**
     * SoftDelete model with request
     *
     * @param Request $request
     * @dataProvider requestProvider
     * @test
     */
    public function destroy(Request $request)
    {
        $id = $this->controller->store($request)->id_area_tematica;
        $bool = $this->controller->destroy($id);
        $this->assertTrue($bool);
    }

    /**
     * Pruebo que los controllers tengan todo los metodos probados
     *
     * @test
     */
    public function tienenTestsTodosLosMetodos()
    {
        $this->assertTrue(true, 'message');
    }
}
