<?php

namespace Tests\Controllers;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\PacsController;
use App\Models\Pac\Pac;
use Tests\TestCase;

class PacControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $model;
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->model = new Pac;
        $this->controller = new PacsController;
    }

    public function PacDataProvider()
    {
        $this->refreshApplication();

        return factory(\App\Models\Pac\Pac::class, 3)
        ->make()
        ->map(function($model){
            return [new Request($model->toArray())];
        })
        ->all();
    }

    /**
     * A basic test example.
     *
     * @dataProvider PacDataProvider
     * @test
     * @return void
     */
    public function store(Request $request)
    {
        $model_instance_id = $this->controller->store($request);
        $this->assertTrue(is_numeric($model_instance_id));
    }

    public function makeDestinatarios($cantidad)
    {
        return factory(\App\Funcion::class, $cantidad)->create();
    }

    /**
     * A basic test example.
     *
     * @dataProvider PacDataProvider
     * @test
     * @return void
     */
    public function storeOneDestinatario(Request $request)
    {
        $id_destinatario = $this->makeDestinatarios(1)->id_funcion;
        $request->query->set('destinatarios', $id_destinatario);
        $model_instance_id = $this->controller->store($request);
        $model = $this->model->with('destinatarios')->findOrFail($model_instance_id);
        $this->assertTrue(is_numeric($model->destinatarios()->get()->first()->id_funcion));
    }

    /**
     * A basic test example.
     * @dataProvider PacDataProvider
     * @test
     * @return void
     */
    public function storeManyDestinatarios(Request $request)
    {
        $destinatarios = $this->makeDestinatarios(2)->map(function ($destinatario) {
            return $destinatario->id_funcion;
        });
        $destinatarios = implode($destinatarios->all(), ',');
        $request->query->set('destinatarios', $destinatarios);
        $model_instance_id = $this->controller->store($request);
        $model = $this->model->with('destinatarios')->findOrFail($model_instance_id);
        $this->assertEquals(2, $model->destinatarios()->get()->count());
    }

    /**
     * A basic test example.
     * @dataProvider PacDataProvider
     * @test
     * @return void
     */
    public function storeOneAccion(Request $request)
    {
        $accion = true;
        $nombre = 'asd';
        $id_linea_estrategica = 5;
        $id_area_tematica = 5;
        $request->query->set('accion', $accion);
        $request->query->set('nombre', $nombre);
        $request->query->set('id_linea_estrategica', $id_linea_estrategica);
        $request->query->set('id_area_tematica', $id_area_tematica);
        $model_instance_id = $this->controller->store($request);
        $model = $this->model->with('acciones')->findOrFail($model_instance_id);
        $this->assertTrue($model->acciones()->get()->id_curso);
    }

    /**
     * A basic test example.

     * @dataProvider PacDataProvider
     * @test
     * @return void
     */
    public function show(Request $request)
    {
        $this->assertTrue(true);
    }

    /**
     * A basic test example.
     *
     * @dataProvider PacDataProvider
     * @test
     * @return void
     */
    public function update(Request $request)
    {
        $this->assertTrue(true);
    }
}
