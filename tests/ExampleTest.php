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
        $user = factory(\App\User::class)->create(['password' => 'test']);

        $this->visit('/dashboard')
        ->click('Entrar')
        ->see('Iniciar sesión')
        ->seePageIs('/entrar')
        ->type($user->name, 'name')
        ->type('test', 'password')
        ->press('entrar')
        ->seePageIs('/dashboard');
    }
}
