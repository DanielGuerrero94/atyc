<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\ProfesoresController;
use Illuminate\Http\Request;

class DocentesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Provider.
     * 
     * @return Request
     */
    public static function filtrosRequest()
    {
        return array(
            array(new Request(array('filtros' => array(
            	'id_tipo_documento' => 1
            )))),
            array(new Request(array('filtros' => array(
            	'id_tipo_documento' => 2
            )))),
            array(new Request(array('filtros' => array(
            	'id_tipo_documento' => 3
            ))))
        );
    }

    /**
     * Funcionan todos los test de los docentes.
     * 
     * @test
     * @dataProvider filtrosRequest
     * @param Request $r
     * @return void
     */
    public function funcionanTodosLosFiltros(Request $r)
    {
    	$controller = new ProfesoresController();
    	$controller->getFiltrado($r);
    	$this->assertTrue(actual, 'message');
    }
}
