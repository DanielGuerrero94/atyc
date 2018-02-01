<?php

namespace Tests\Controllers;

use App\Http\Controllers\EfectoresController;
use App\Repositories\EfectoresRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Tests\TestCase;

class EfectoresControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->controller = $this->app->make(EfectoresController::class);
        putenv('DB_DATABASE=atyc');
        $this->refreshApplication();
    }

    public function tearDown()
    {
        putenv('DB_DATABASE=atyc_testing');
        $this->refreshApplication();
    }

    /**
     * @test
     */
    public function itShouldFilterEfectoresByProvincia($id_provincia = 12)
    {
        $count = $this->controller->queryLogica(new Request, compact('id_provincia'))->count();
        $this->assertEquals(143, $count);
    }

    /**
     * @test
     */
    public function itShouldReturnDepartamentos()
    {
        $count = $this->controller->queryLogica(new Request)->count();
        $this->assertEquals(9284, $count);
    }
}
