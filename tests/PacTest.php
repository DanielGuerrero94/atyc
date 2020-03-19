<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Pac\Pac;

class PacTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
	$count = Pac::count();
        $this->assertEquals(21, $count);
    }

    /**
     * Crea una pac.
     *
     * @return void
     */
    public function testCreate()
    {
	//$pac = factory(Pac::class)->create();
	$count = Pac::count();
        $this->assertEquals(21, $count);
        //$this->assertNotNull($pac->nombre);
	//$pac->delete();
	$count = Pac::count();
        $this->assertEquals(21, $count);
    }

    /**
     * Busca que existan todas las relaciones del modelo con otras tablas.
     *
     * @return void
     */
    public function testPivots()
    {
        $pac = Pac::with('destinatarios', 'pautas', 'responsables', 'componentes', 'tipoAccion', 'tematicas')
             ->where('id_pac', 31)->first();
	$this->assertNotNull($pac->destinatarios[0]);
	$this->assertNotNull($pac->pautas[0]);
	$this->assertNotNull($pac->responsables[0]);
	$this->assertNotNull($pac->componentes[0]);
	$this->assertNotNull($pac->tipoAccion);
	$this->assertNotNull($pac->tematicas[0]);
    }


    /**
     * Crea pac desde controller.
     *
     * @return void
     */
    public function testController()
    {
	$this->markTestIncomplete();
	$pac = factory(Pac::class)->make();
	$request = request($pac);
	$result = app('PacController')->store($request);
    }


}
