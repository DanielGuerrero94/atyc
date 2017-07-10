<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Controller extends TestCase
{
    /**
     * Devuelve string true en vez de boolean.
     *
     * @test
     * @return void
     */
    public function checkDocumentsReturnJson()
    {
        $controller = new App\Http\Controllers\alumnosController();
        $this->assertTrue(json_decode($controller->checkDocumentos(30087533)));
    }
}
