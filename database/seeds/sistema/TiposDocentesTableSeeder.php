<?php

use Illuminate\Database\Seeder;

class TiposDocentesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(
            "INSERT INTO sistema.tipos_docentes (nombre) values
            ('Profesor'),
            ('Tallerista'),
            ('Tutor'),
            ('Mentor'),
            ('Observador')
        ");
    }
}
