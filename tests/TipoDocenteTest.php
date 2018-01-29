<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\TipoDocentesController;
use App\TipoDocente;

class TipoDocenteTest extends TestCase
{
    protected static $stack;
    protected $controller;
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $this->controller = app(TipoDocentesController::class);
        $this->model = app(TipoDocente::class);
    }

    public static function tiposDocentesRequest()
    {
        return [
            [new Request(['nombre' => 'docenteA'])],
            [new Request(['nombre' => 'docenteB'])],
            [new Request(['nombre' => 'docenteC'])]
        ];
    }

    public static function updateTiposDocentesRequest()
    {
        return array(
            array(new Request(array('nombre' => 'orador'))),
            array(new Request(array('nombre' => 'jefe de catedra'))),
            array(new Request(array('nombre' => 'decano')))
        );
    }

    public static function stacks()
    {
        return self::$stack;
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$stack = [];
    }

    /**
     * Create model with request
     *
     * @param Request $r
     * @test
     * @dataProvider tiposDocentesRequest
     * @return void
     */
    public function create(Request $r)
    {
        $controller = new TipoDocentesController();

        $id = $controller->store($r)->id_tipo_docente;
        $this->assertNotNull($id, 'No se pudo crear');
        $this->assertTrue(TipoDocente::find($id)->exists, 'No se persistio');
        array_push(self::$stack, $id);
    }

    /**
     * Update model with request
     *
     * @param Request $r
     * @test
     * @dataProvider updateTiposDocentesRequest
     * @return void
     */
    public function update(Request $r)
    {
        $controller = new TipoDocentesController();
        $id = $controller->store($r)->id_tipo_docente;

        $antes = TipoDocente::find($id)->first()->nombre;
        $controller->update($r, $id);
        $despues = TipoDocente::find($id)->nombre;
        $this->assertFalse($antes === $despues, 'Son iguales no se hizo el update');
    }

    /**
     * SoftDelete on model
     *
     * @test
     */
    public function destroy()
    {
        $controller = new TipoDocentesController();

        collect($this->stacks())->each(function ($item, $key) use ($controller) {
            $controller->destroy($item);
        });

        $this->assertTrue(TipoDocente::all()->count() === 0, 'No hizo el SoftDelete');
    }
}
