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
     * Provider request desde json
     *
     * @return Request
     */
    public static function requestStore()
    {
        return array(
            array(new Request(
                json_decode('{"nombres":"testA","apellidos":"testingA","nro_doc":"12345678",
                    "email":"testingA@testing.com","tel":"12345678","cel":"12345678","id_tipo_documento":"1",
                    "id_tipo_docente":"5"}', true)
            )
            ),
            array(new Request(
                json_decode('{"nombres":"testB","apellidos":"testingB","nro_doc":"12345679",
                    "email":"testingB@testing.com","tel":"12345679","cel":"12345679","id_tipo_documento":"2",
                    "id_tipo_docente":"4"}', true)
            )
            )
        );
    }

    /**
     * Provider request desde json con datos errones
     *
     * @return Request
     */
    public static function requestIncompleteOrWrongStore()
    {
        return array(
            array(new Request(
                json_decode('{"apellidos":"testin","cel":"12345678"}', true)
            )
            ),
            array(new Request(
                json_decode('{"apellid":"ngB","tel":"a4aa679","id_tipo_docente":"12"}', true)
            )
            )
        );
    }

    /**
     * Funcionan todos los filtros de los docentes.
     *
     * @test
     * @dataProvider filtrosRequest
     * @param Request $r
     * @return void
     */
    public function funcionanTodosLosFiltros(Request $r)
    {
        $controller = new ProfesoresController();
        $r = $controller->getFiltrado($r);
        $this->assertTrue($r, 'message');
    }

    /**
     * Crea bien los docentes.
     *
     * @test
     * @dataProvider requestStore
     * @param Request $r
     * @return void
     */
    public function creaElDocente(Request $r)
    {
        $controller = new ProfesoresController();
        $r = $controller->store($r);
        $this->assertTrue($r->status);
    }

    /**
     * Falla .
     *
     * @test
     * @dataProvider requestIncompleteOrWrongStore
     * @param Request $r
     * @return void
     */
    public function noLograCrearDocente(Request $r)
    {
        $controller = new ProfesoresController();
        $r = $controller->store($r);
        $this->assertFalse($r->status);
    }
}
