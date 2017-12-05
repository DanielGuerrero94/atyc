<?php

namespace Tests\Controllers;

use App\Http\Controllers\EfectoresController;
use App\Repositories\EfectoresRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class EfectoresControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        //config(['database.connections.pgsql.database' => 'atyc']);
        $this->controller = resolve(EfectoresController::class);
    }

    /**
     * @test
     */
    public function it_should_filter_efectores_by_provincia($id_provincia = 12)
    {
        $count = $this->controller->queryLogica(null, compact('id_provincia'))->count();
        $this->assertEquals(143, $count, 'No coincide la cantidad: '.$count);
        //config(['database.connections.pgsql.database' => 'atyc_testing']);
    }

    /**
     */
    public function it_should_return_departamentos()
    {
        $count = $this->controller->queryLogica(null, compact('id_provincia'))->count();
        $this->assertEquals(143, $count, 'No coincide la cantidad: '.$count);
        //config(['database.connections.pgsql.database' => 'atyc_testing']);
    }
}
