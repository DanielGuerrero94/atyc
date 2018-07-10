<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class PacAPITest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * Pide una PAC
     * @test
     * @return void
     */
    public function devuelveLaPac(Request $request)
    {
        $response = $this->json('GET', "/pac//{$cliente->id_cliente}/direcciones");
        $response->assertStatus(200);
    }


    /**
    * Intenta decrementar la cantidad de repticiones de una pac.
     * @return void
     */
    public function incrementaRepeticiones(Request $request)
    {
        $response = $this->json('GET', "/api/clientes/{$cliente->id_cliente}/direcciones");
        $request = $this->accionRequest($request);
        $model_instance_id = $this->controller->store($request);
        $model = $this->model->with('acciones')->findOrFail($model_instance_id);
        $this->assertNull($model->acciones()->first()->updated_at);
    }
}
