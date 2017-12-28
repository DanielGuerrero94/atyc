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
        $request->query->set('id_destinatario', $id_destinatario);
        $model_instance_id = $this->controller->store($request);
        $model = $this->model->with('destinatarios')->findOrFail($model_instance_id);
        $this->assertTrue(is_numeric($model->destinatarios()->get()->first()->id_funcion));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function storeManyDestinatarios(Request $request)
    {
        $id_destinatario = $this->makeDestinatarios(1);
        $model_instance_id = $this->controller->store($request)->id_pac;
        $id_destinatario = $this->model->with('destinatarios')->findOrFail($model_instance_id);
        $this->assertTrue(is_numeric($id_destinatario));
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
