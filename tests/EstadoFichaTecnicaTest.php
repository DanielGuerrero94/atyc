<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Pac\EstadoFichaTecnica as Model;

class EstadoFichaTecnicaTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->model = $this->app->make(Model::class);
        $this->model->truncate();
    }


    /** @test */
    public function can_create_instance()
    {
        $this->assertNotNull($this->model);
    }

    /** @test */
    public function can_create_state()
    {
        $data = [
            "id_estado_ficha_tecnica" => '1',
            "descripcion" => "Requiere completar",
            "class" => "bg-red"
        ];

        $this->model->create($data);
    }
}
