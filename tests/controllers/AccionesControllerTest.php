<?php

namespace Tests\Controllers;

use App\Http\Controllers\CursosController;
use App\Models\Cursos\Curso;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Tests\TestCase;

class AccionesControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $this->controller = $this->app->make(CursosController::class);
        $this->model = $this->app->make(Curso::class);
    }

    public function requestProvider()
    {
        $this->refreshApplication();
        return factory(Curso::class, 3)
        ->make()
        ->map(function ($i) {
            return [new Request($i->toArray())];
        })
        ->all();
    }

    /**
     * Return date with the correct format. "16/10/2013"
     *
     * @test
     */
    public function showCorrectDateFormat()
    {
        
        $curso = factory(Curso::class)->make();
        $curso->save();
        $curso = $this->controller->show($curso->id_curso);
        $curso = json_decode($curso['curso'], true);
        $fecha = $curso['fecha'];

        $this->assertRegExp('/\d+\/\d+\/\d+/', $fecha, 'No tiene el formato correcto');
    }

    /**
     * 
     *
     * @param Request $request
     * @dataProvider requestProvider
     * @test
     */
    public function create(Request $request)
    {
        $id_accion = $this->controller->store($request)->id_curso;
        $this->assertTrue(is_numeric($id_accion));
    }

    /**
     * Depende de base de datos
     *
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     * @test
     */
    public function getAlumnos()
    {
        $curso = $this->controller->getAlumnos(1);
    }
}
