<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class DocenteControllerTest extends TestCase
{
	protected $model;
	protected $controller;

	public function setUp()
    {
        parent::setUp();
        $this->controller = new App\Http\Controllers\ProfesoresController();
        $this->model = new App\Profesor();
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
}
