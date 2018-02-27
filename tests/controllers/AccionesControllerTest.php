<?php

namespace Tests\Controllers;

use App\Http\Controllers\CursosController;
use App\Models\Cursos\Curso;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Tests\TestCase;
use DB;

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
            $param = $i->toArray();
            $param['duracion'] = intval($param['duracion']);
            return [new Request($param)];
        })
        ->all();
    }

    public function fakerRequestProvider()
    {
        return factory(Curso::class, 5)->make()->map(function ($model) {
            return new Request($model->toArray());
        });
    }

    /**
     * Return date with the correct format. "16/10/2013"
     *
     * @test
     */
    public function showCorrectDateFormat()
    {
        $curso = factory(Curso::class)->states('completo')->create();
        $curso = $this->controller->show($curso->id_curso);
        $curso = json_decode($curso['curso'], true);
        $fecha = $curso['fecha'];

        $this->assertRegExp('/\d+\/\d+\/\d+/', $fecha, 'No tiene el formato correcto');
    }

    /**
     * Store model with request
     *
     * @test
     * @return void
     */
    public function create()
    {
        $requests = factory(Curso::class, 2)->states('completo')->make()->map(function ($model) {
            return new Request($model->toArray());
        });
        foreach ($requests as $request) {
            $accion = $this->controller->store($request);
            $this->assertNotNull($accion, json_encode($accion));
        }
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

    /**
     * Depende de base de datos
     *
     * @test
     */
    public function getProfesores()
    {
        $accion = factory(Curso::class)->create();
        $ids_profesores = factory(\App\Profesor::class, 3)
        ->create()
        ->map(function ($model) {
            return $model->id_profesor;
        })
        ->toArray();

        $id_profesores = array_values($ids_profesores);
        $accion->profesores()->attach($ids_profesores);
        $datatable = $this->controller->getProfesores($accion->id_curso);
        $this->assertEquals('200', $datatable->status());
    }

    /**
     * Model table is present but not filled with records
     *
     * @test
     */
    public function empty()
    {
        DB::statement("truncate cursos.cursos cascade");
        $this->assertCount(0, $this->model->all());
    }

    /**
     * Show model with request
     *
     * @param Request $request
     * @dataProvider requestProvider
     * @test
     */
    public function show(Request $request)
    {
        $id = $this->controller->store($request)->id_curso;
        $array = $this->controller->show($id);
        $this->assertArrayHasKey('curso', $array);
    }

    /**
     * Update model with request
     *
     * @param Request $request
     * @dataProvider requestProvider
     * @test
     */
    public function update(Request $request)
    {
        $id = $this->controller->store($request)->id_curso;
        $antes = $this->model->findOrFail($id)->first()->nombre;
        $request->replace(['nombre' => strtoupper($request->nombre)]);
        $this->controller->update($request, $id);
        $despues = $this->model->findOrFail($id)->nombre;
        $this->assertFalse($antes === $despues, 'Son iguales no se hizo el update');
    }

    /**
     * SoftDelete model with request
     *
     * @param Request $request
     * @dataProvider requestProvider
     * @test
     */
    public function destroy(Request $request)
    {
        $id = $this->controller->store($request)->id_curso;
        $bool = $this->controller->destroy($id);
        $this->assertTrue($bool);
    }

    /**
     * get participantes by cuie
     *
     * @test
     */
    public function getByCuie()
    {
        $accion = factory(Curso::class)->create();
        $ids_participantes = factory(\App\Alumno::class, 3)
        ->create(['establecimiento1' => 'N95802'])
        ->map(function ($model) {
            return $model->id_alumno;
        })
        ->toArray();

        $ids_participantes = array_values($ids_participantes);
        $accion->alumnos()->attach($ids_participantes);
        $capacitados = $this->model->getByCuie('N95802')->first();
        $this->assertEquals('N95802', $capacitados->establecimiento1);
        $this->assertEquals(3, $capacitados->alumnos);
    }
}
