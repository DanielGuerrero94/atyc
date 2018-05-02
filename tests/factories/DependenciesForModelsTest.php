<?php

namespace Tests\Factories;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use DB;

class DependenciesForModelsTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
 
    public function dependencyTest($class, $id_name, $quantity)
    {
        $id = $class::select($id_name)
        ->pluck($id_name)
        ->shuffle()
        ->first();

        $id = $id?:factory($class, $quantity)
        ->create()
        ->shuffle()
        ->first()
        ->id_name;

        return $id;
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTipoDocumento()
    {
        DB::statement("ALTER SEQUENCE sistema.tipos_documentos_id_tipo_documento_seq restart with 1;");
        $this->dependencyTest('App\TipoDocumento', 'id_tipo_documento', 4);
        $id = $this->dependencyTest('App\TipoDocumento', 'id_tipo_documento', 4);
        $this->assertTrue($id >= 1 && $id <= 4);
    }

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function trabajo()
    {
        DB::statement("ALTER SEQUENCE alumnos.trabajos_id_trabajo_seq restart with 1;");
        $this->dependencyTest('App\Trabajo', 'id_trabajo', 4);
        $id = $this->dependencyTest('App\Trabajo', 'id_trabajo', 4);
        $this->assertTrue($id >= 1 && $id <= 4);
    }
}
