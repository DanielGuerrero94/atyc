<?php

use Illuminate\Database\Seeder;
use App\Models\Pac\Actor;

class ActoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Actor::updateOrCreate([
            'id_actor' => Actor::SUMAR,
        ], [
            'nombre'      => 'Sumar',
            'descripcion' => 'Actor perteneciente al Programa Sumar',
        ]);

        Actor::updateOrCreate([
            'id_actor' => Actor::REDES,
        ], [
            'nombre'      => 'Redes',
            'descripcion' => 'Actor perteneciente al Programa Redes',
        ]);

        Actor::updateOrCreate([
            'id_actor' => Actor::PROTEGER,
        ], [
            'nombre'      => 'Proteger',
            'descripcion' => 'Actor perteneciente al Programa Proteger',
        ]);

        Actor::updateOrCreate([
            'id_actor' => Actor::TELESALUD,
        ], [
            'nombre'      => 'Telesalud',
            'descripcion' => 'Actor perteneciente al Programa Telesalud',
        ]);

        Actor::updateOrCreate([
            'id_actor' => Actor::INTEGRADO,
        ], [
            'nombre'      => 'Integrado',
            'descripcion' => 'Actor perteneciente a un sector Integrado',
        ]);
    }
}
