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
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->controller = $this->app->make(PacsController::class);
        $this->model = $this->app->make(Pac::class);
    }

    public function loginFakeUser()
    {
        $this->be(factory(\App\User::class)->create());
    }

    public function makeDestinatarios($cantidad)
    {
        return factory(\App\Funcion::class, $cantidad)->create();
    }

    public function PacDataProvider()
    {
        $this->refreshApplication();

        return factory(Pac::class, 2)
        ->make()
        ->map(function ($model) {
            return array(new Request($model->toArray()));
        })
        ->all();
    }

    /**
     * Store model with request
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
        $this->assertTrue(is_numeric($model->destinatarios()->first()->id_funcion));
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
        $this->assertTrue(is_numeric($model->acciones()->first()->id_curso));
    }

    /**
     * A basic test example.
     *
     * @dataProvider PacDataProvider
     * @test
     * @return void
     */
    public function show(Request $request)
    {
        $this->loginFakeUser();
        $id = $this->controller->store($request);
        $array = $this->controller->show($id);
        $this->assertArrayHasKey('pac', $array);
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
        $this->markTestIncomplete();
    }

    /**
     * Assert that all options keys get passed to the views.
     *
     * @test
     */
    public function getSelectOptions()
    {
        $data = $this->controller->getSelectOptions();

        $expected = ['tipologias', 'tematicas'];
        $this->assertArraySubset($expected, array_keys($data));
    }
}
