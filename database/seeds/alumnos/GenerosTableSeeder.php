<?php

use Illuminate\Database\Seeder;

class GenerosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(
            "INSERT INTO alumnos.generos (nombre) values
            ('Masculino'),
            ('Femenino'),
            ('Otro')
        "
        );
    }
}
