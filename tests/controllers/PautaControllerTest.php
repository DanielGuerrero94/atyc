<?php

namespace Tests\Controllers;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

use App\Models\Pac\Pauta;
use App\Http\Controllers\PautasController;

use Illuminate\Http\Request;

class PautaControllerTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->model = $this->app->make(Pauta::class);
        $this->controller = $this->app->make(PautasController::class);
    }

    public function pautaDataProvider()
    {
        $this->refreshApplication();

        return factory(Pauta::class, 2)
        ->make()
        ->map(function ($model) {
            return array(new Request($model->toArray()));
        })
        ->all();
    }

    public function fakePauta(Request $request)
    {
        return $this->controller->store($request);
    }

    /** 
     * @dataProvider pautaDataProvider
     * @test 
     * */
    public function noPuedeCrearPautaSinComponentes($request)
    {
        $this->markTestIncomplete();
        $response = $this->controller->store($request);
        $response->seeStatusCode(400);
    }

    /** 
     * @dataProvider pautaDataProvider
     * @test 
     * */
    public function puedeActualizarComponentesDeUnaPauta($request)
    {
        $pauta = $this->fakePauta($request)->content();
        $id_pauta = json_decode($pauta)->id_pauta;
        $this->assertNotNull($id_pauta);
        $pauta = $this->model->findOrFail($id_pauta);
        $this->assertEquals(0, $pauta->componentes()->count());
        $componentes = factory(\App\Models\Pac\ComponenteCa::class, 2)->create()->map(function($componente) {
            return $componente->id_componente_ca;
        })->toArray();

        $componentes = implode(",", $componentes);

        $request->request->add(compact('componentes'));
        $this->controller->update($request, $id_pauta);
        $this->assertEquals(2, $pauta->componentes()->count());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPacDevuelveSusComponentes()
    {   
        $this->markTestIncomplete();
        $id_pauta = factory(\App\Models\Pac\Pauta::class)->create()->id_pauta;

        $pauta = $this->app->make(\App\Models\Pac\Pauta::class);
        $pauta::findOrFail($id_pauta);
        $pauta->asociarComponente();
        $response = $this->controller->conComponentes(request(), $id_pauta);
        $response = json_decode($response);
        $this->assertNull($response->componentes);
    }
}
