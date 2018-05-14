<?php

namespace Tests\API;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoriaPautaAPITest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function index()
    {
        $this->get("/categoriasPautas")
            ->seeStatusCode(200);
    }

    /** @test */
    public function table()
    {
        $this->get("/categoriasPautas/tabla")
            ->seeStatusCode(200)
            ->seeJson();
    }

}
