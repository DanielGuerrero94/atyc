<?php

namespace Tests\API;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PautasAPITest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function index()
    {
        $this->get("/pautas")
            ->seeStatusCode(200);
    }

    /** @test */
    public function table()
    {
        $this->get("/pautas/tabla")
            ->seeStatusCode(200)
            ->seeJson();
    }

    /** @test */
    public function typeahead()
    {
        $this->get("/pautas/typeahead")
            ->seeStatusCode(200);
    }
}
