<?php

namespace Tests\Controllers;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\FichaTecnicaController;
use Tests\TestCase;

class FichaTecnicaControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->controller = $this->app->make(FichaTencicaController::class);
        $this->model = $this->app->make(FichaTecnica::class);
    }

    /**
     * Store model with request
     *
     * @test
     * @return void
     */
    public function store()
    {
        $request = new Request();
        $request->files();
        $model_instance_id = $this->controller->store($request);
        $this->assertTrue(is_numeric($model_instance_id));
    }

}
