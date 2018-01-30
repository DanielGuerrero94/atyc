<?php

namespace Tests\Controllers;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\TipoDocentesController;
use App\TipoDocente;
use Tests\TestCase;

class TipoDocentesControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->controller = $this->app->make(TipoDocentesController::class);
        $this->model = $this->app->make(TipoDocente::class);
    }

    public function requestProvider()
    {
        $this->refreshApplication();
        return factory(TipoDocente::class, 3)
        ->make()
        ->map(function ($i) {
            return [new Request($i->toArray())];
        })
        ->all();
    }

    /**
     * Model table is present but not filled with records
     *
     * @test
     */
    public function empty()
    {
        $this->assertCount(0, $this->model->all());
    }

    /**
     * Create view of the model
     *
     * @test
     */
    public function create()
    {
        $this->assertEquals('a2efda22b3f64cb92fed888ac8481a91', md5($this->controller->create()));
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
        $id = $this->controller->store($request)->id_tipo_docente;
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
        $id = $this->controller->store($request)->id_tipo_docente;
        $array = $this->controller->show($id);
        $this->assertArrayHasKey('tipo_docentes', $array);
    }

    /**
     * Edit view of the model
     *
     * @test
     */
    public function edit()
    {
        $id = $this->controller->store(new Request(['nombre' => 'testing']))->id_tipo_docente;
        $view = $this->controller->edit($id);
        $this->assertEquals('ae2b1fca515949e5d54fb22b8ed95575', md5($view), $view);
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
        $id = $this->controller->store($request)->id_tipo_docente;
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
        $id = $this->controller->store($request)->id_tipo_docente;
        $bool = $this->controller->destroy($id);
        $this->assertTrue($bool);
    }

    /**
     * Store model with request fails
     *
     * @test
     */
    public function storeFails()
    {
        $response = $this->controller->store(new Request(['invalid' => 'parameter']));
        $this->assertEquals('The given data failed to pass validation.', $response->getOriginalContent());
    }

    /**
     * Update model with request fails
     *
     * @test
     */
    public function updateFails()
    {
        $id = $this->controller->store(new Request(['nombre' => 'testing']))->id_tipo_docente;
        $response = $this->controller->update(new Request(['invalid' => 'parameter']), $id);
        $this->assertEquals('The given data failed to pass validation.', $response->getOriginalContent());
    }
}
