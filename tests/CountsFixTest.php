<?php

namespace Tests;

use App\Alumno;
use App\Models\Cursos\Curso;
use App\Profesor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CountsFixTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        putenv('DB_DATABASE=atyc');
        $this->refreshApplication();
    }

    public function tearDown()
    {
        //putenv('DB_DATABASE=atyc_testing');
        $this->refreshApplication();
    }

    /**
     * @test
     */
    public function countParticipantes()
    {
        $participantes = Alumno::count();
        $this->assertEquals(48102, $participantes);
        $this->assertEquals(96, Alumno::has('cursos')->whereNull('created_at')->count());
        Alumno::has('cursos')->whereNull('created_at')->get()->each(function ($model) {
            $date = $model->cursos->sort()->first()->fecha;
            $date = date_create_from_format('d/m/Y', $date)->format('Y-m-d H:i:s');
            $model->created_at = $date;
            $model->updated_at = $date;
            $model->save();
        });
        $this->assertEquals(0, Alumno::whereNull('created_at')->count());
        $this->assertEquals(0, Alumno::whereNull('updated_at')->count());
    }

    /**
     * @test
     */
    public function countDocentes()
    {
        $docentes = Profesor::count();
        $this->assertEquals(475, $docentes);
        $this->assertEquals(427, Profesor::has('cursos')->whereNull('created_at')->count());
        Profesor::has('cursos')->whereNull('created_at')->get()->each(function ($model) {
            $date = $model->cursos->sort()->first()->fecha;
            $date = date_create_from_format('d/m/Y', $date)->format('Y-m-d H:i:s');
            $model->created_at = $date;
            $model->updated_at = $date;
            $model->save();
        });
        $this->assertEquals(0, Profesor::whereNull('created_at')->count());
        $this->assertEquals(0, Profesor::whereNull('updated_at')->count());
    }

    /**
     * @test
     */
    public function countAcciones()
    {
        $acciones = Curso::count();
        $this->assertEquals(9215, $acciones);
        $this->assertEquals(8206, Curso::where('created_at', '2017-08-28 11:25:51')->count());

        Curso::where('created_at', '2017-08-28 11:25:51')->get()->each(function ($model) {
            $date = $model->fecha;
            $date = date_create_from_format('d/m/Y', $date)->format('Y-m-d H:i:s');
            $model->created_at = $date;
            $model->updated_at = $date;
            $model->save();
        });

        $this->assertEquals(0, Curso::where('created_at', '2017-08-28 11:25:51')->count());
    }
}
