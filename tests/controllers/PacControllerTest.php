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
        $this->markTestSkipped();
        $id_destinatario = $this->makeDestinatarios(1)->id_funcion;
        $request->query->set('destinatarios', $id_destinatario);
        $id = $this->controller->store($request);
        $this->assertNull($id);
        $model = $this->model->with('destinatarios')->findOrFail($id);
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

    public function accionRequest(Request $request)
    {
        $accion = true;
        $nombre = 'asd';
        $id_linea_estrategica = 5;
        $id_area_tematica = 5;
        $request->query->set('accion', $accion);
        $request->query->set('nombre', $nombre);
        $request->query->set('id_linea_estrategica', $id_linea_estrategica);
        $request->query->set('id_area_tematica', $id_area_tematica);
        return $request;
    }

    /**
     * A basic test example.
     * @dataProvider PacDataProvider
     * @test
     * @return void
     */
    public function storeOneAccion(Request $request)
    {
        $this->markTestSkipped();
        $request = $this->accionRequest($request);
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
        $this->markTestSkipped();
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
        $this->markTestSkipped();
        $request = $this->accionRequest($request);
        $id = $this->controller->store($request);
        $model = $this->model->findOrFail($id);

        $destinatarios = $model->with('destinatarios')->first()->destinatarios->map(function ($value) {
            return $value->id_funcion;
        })->toArray();

        $destinatarios = implode(",", $destinatarios);

        $this->assertEquals($destinatarios, $this->model->getAllDestinatarios());

        $request = new Request();
        $request->query->set('nombre', 'updated');
        $request->query->set('destinatarios', $destinatarios);
        $request->query->set('componentesCa', []);
        $request->query->set('pautas', []);
        $request->query->set('areasTematicas', []);

        $response = $this->controller->update($request, $id);
        $this->assertNull($response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
        $model = $this->model->findOrFail($id);
        $this->assertEquals('updated', $model->nombre);
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

    /**
     * A basic test example.
     * @dataProvider PacDataProvider
     * @test
     * @return void
     */
    public function storeOneAccionWithTimestamp(Request $request)
    {
        $this->markTestSkipped();
        $request = $this->accionRequest($request);
        $model_instance_id = $this->controller->store($request);
        $model = $this->model->with('acciones')->findOrFail($model_instance_id);
        $this->assertNull($model->acciones()->first()->updated_at);
    }

   /**
     * A basic test example.
     * @return void
     */
    public function storeneAccionWithTimestamp(Request $request)
    {
        $request = $this->accionRequest($request);
        $model_instance_id = $this->controller->store($request);
        $model = $this->model->with('acciones')->findOrFail($model_instance_id);
        $this->assertNull($model->acciones()->first()->updated_at);
    }

}
