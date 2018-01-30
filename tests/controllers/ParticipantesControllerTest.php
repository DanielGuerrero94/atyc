<?php

namespace Tests\Controllers;

use App\Alumno;
use App\Http\Controllers\AlumnosController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Tests\TestCase;

class ParticipantesControllerTest extends TestCase
{
       use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->controller = app(AlumnosController::class);
        $this->model = app(Alumno::class);
    }

    public function requestProvider()
    {
        $this->refreshApplication();
        return factory(Alumno::class, 3)
        ->make()
        ->map(function ($i) {
            return [new Request($i->toArray())];
        })
        ->all();
    }

    /**
     * A basic test example.
     *
     * @test
     * @dataProvider requestProvider
     * @return void
     */
    public function create(Request $request)
    {
        //$participante = $this->controller->store($request);
        //$this->assertNull(null);
        $this->assertTrue(true);
    }
}
