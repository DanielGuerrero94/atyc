<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class ParticipantesControllerTest extends TestCase
{
	protected $controller;
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $this->controller = new App\Http\Controllers\AlumnosController();
        $this->model = new App\Alumno();
    }

    public function participantesRequestProvider()
    {
        $requests = [];
        $filename = env('APP_PATH').'storage/logs/production/create-participante-2017-09-28.log';

        $f = fopen($filename, 'r');

        while (!feof($f)) {            
            $line = fgets($f);
            $request_array = json_decode($line,true);
            $request = new Request($request_array);   
            array_push($requests, [$request]);
        }
        return $requests;
    }

    /**
     * A basic test example.
     *
     * @test
     * @dataProvider participantesRequestProvider
     * @return void
     */
    public function create(Request $request)
    {
    	//$participante = $this->controller->store($request);
        //$this->assertNull(null);
        $this->assertTrue(true);
    }
}
