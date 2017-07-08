<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
            ->see('Laravel');
    }

    /**
     * Crea AreaTematica.
     *
     * @return void
     */
    public function testCreateAT()
    {
        $attr = array('nombre' => 'test');
        $this->assertNotNull(App\Models\Cursos\AreaTematica::create($attr), 'message');
    }
}
