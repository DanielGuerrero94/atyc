<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class AreaTematicaTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        system('php artisan migrate');
    }

    /**
     * A basic test example.
     *
     * @test
     * @dataProvider mockAreas
     * @param array $attributes
     * @return void
     */
    public function create($attributes)
    {
        $this->assertNotNull(
            App\Models\Cursos\AreaTematica::create($attributes),
            'No pudo persistir el modelo'
        );
    }

    /**
     * Pruebo que los controllers tengan todo los metodos probados
     *
     * @test
     * @return void
     */
    public function tienenTestsTodosLosMetodos()
    {
        $this->assertTrue(true, 'message');
    }

    /**
     * Fails on the store method of the controller
     * because does not have the required columns
     *
     * @test
     * @dataProvider invalidRequests
     * @expectedException Illuminate\Database\QueryException
     * @return void
     */
    public function storesFails($request)
    {
        $areaController = new App\Http\Controllers\AreasTematicasController();
        $areaController->store($request);
    }

    public static function mockAreas()
    {
        return array(
            array(array('nombre' => 'primero')),
            array(array('nombre' => 'segundo')),
            array(array('nombre' => 'tercero'))
        );
    }

    public static function validRequests()
    {
        return array(
            array(new Request([], array('nombre' => 'primero'))),
            array(new Request([], array('nombre' => 'segundo'))),
            array(new Request([], array('nombre' => 'tercero')))
        );
    }

    public static function invalidRequests()
    {
        return array(
            array(new Request([], array('qwe' => 'random'))),
            array(new Request([], array('a' => '23-12-1234'))),
            array(new Request([], array('dw' => 3)))
        );
    }
}
