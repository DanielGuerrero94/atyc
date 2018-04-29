<?php

namespace Tests\Controllers;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\FichaTecnicaController;
use App\Models\Pac\FichaTecnica;
use Tests\TestCase;
use DB;

class FichaTecnicaControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->controller = $this->app->make(FichaTecnicaController::class);
        $this->model = $this->app->make(FichaTecnica::class);
        DB::statement("ALTER SEQUENCE pac.fichas_tecnicas_id_ficha_tecnica_seq restart with 1;");
    }


    /** @test */
    public function factory_working()
    {
        $ficha_tecnica = factory(FichaTecnica::class)->create();
        $this->assertEquals(1, $ficha_tecnica->id_ficha_tecnica);
    }

    /**
     * Store model with request
     *
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
