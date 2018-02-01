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
     * @test
     * @return void
     */
    public function basicExample()
    {
        $this->visit('/')
            ->see('Laravel');
    }

    /**
     * Dashboard test example.
     *
     * @test
     * @return void
     */
    public function dashboardExample()
    {
        $this->visit('/dashboard')
            ->see('Entrar');
    }

    /**
     * Login test example.
     *
     * @test
     * @return void
     */
    public function login()
    {
        $this->visit('/dashboard')
        ->click('Entrar')
        ->see('Iniciar sesión')
        ->seePageIs('/entrar')
        ->type('jujuy', 'name')
        ->type('jujuy001', 'password')
        ->press('entrar')
        ->seePageIs('/dashboard');
    }
}
