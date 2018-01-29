<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use DB;

class EfectoresTest extends TestCase
{
    private $controller;

    public function setUp()
    {
        parent::setUp();
        $this->controller = new App\Http\Controllers\EfectoresController();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testDevuelveEfectores()
    {
        $this->assertNotNull($this->controller->queryLogica(
            new Request(['filtros' => ['id_provincia' => 12]])
        ), 'No devolvio efectores');
    }
}
