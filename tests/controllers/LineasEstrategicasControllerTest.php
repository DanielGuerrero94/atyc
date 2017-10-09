<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class LineasEstrategicasControllerTest extends TestCase
{
	protected $model;
	protected $controller;

	public function setUp()
    {
        parent::setUp();
        $this->model = new App\Models\Cursos\LineaEstrategica();
        $this->controller = new App\Http\Controllers\LineasEstrategicasController();
    }

    public function lineasEstrategicasRequestProvider()
    {
        $this->refreshApplication();
        return factory(App\Models\Cursos\LineaEstrategica::class, 3)
        ->create()
        ->map(function($i){
            return [new Illuminate\Http\Request($i->toArray())];
        })
        ->all();
    }

    /**
     * Create a model instance and return successfully his primary key
     * 
     * @test
     * @dataProvider lineasEstrategicasRequestProvider 
     * @return void
     */
    public function store(Request $request)
    {
        $model_instance_id = $this->controller->store($request);
        $this->assertTrue(is_numeric($model_instance_id));
    }

    /**
     * Update a model instance and return successfully his primary key
     * 
     * @test
     * @dataProvider lineasEstrategicasRequestProvider 
     * @return void
     */
    public function update(Request $request)
    {
        $model_to_update = $this->controller->show(34)['linea'];

        $modified = $this->controller->update($request,34);

        $this->assertTrue($modified, "Can't update the model.");
        $this->assertNotEquals($model_to_update, $this->controller->show(34)['linea'], 'Son iguales: '.PHP_EOL.$model_to_update.PHP_EOL.$modified);
    }

    /**
     * Show a model instance in an array
     * 
     * @test
     * @return void
     */
    public function show()
    {
        $model_to_update = $this->controller->show(34)['linea'];
        $this->assertInstanceOf(App\Models\Cursos\LineaEstrategica::class, $model_to_update, "It's not the correct model.");
    }
}
