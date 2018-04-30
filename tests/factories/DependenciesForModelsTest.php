<?php

namespace Tests\Factories;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\DatabaseTestCase;
use Tests\TestCase;
use DB;

class DependenciesForModelsTest extends TestCase
{

	public function setUp()
	{
		parent::setUp();
        	DB::statement("ALTER SEQUENCE sistema.tipos_documentos_id_tipo_documento_seq restart with 1;");
	}

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTipoDocumento()
    {
	$this->dependency('\App\TipoDocumento', 'id_tipo_documento', 4);
	$id = $this->dependency('\App\TipoDocumento', 'id_tipo_documento', 4);
        $this->assertTrue($id >= 1 && $id <= 4);
    }
    
    public function dependency($class, $id_name, $quantity) 
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

}
