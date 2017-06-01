<?php

use Illuminate\Database\Seeder;

class ConveniosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO alumnos.convenios(nombre) values
        (''),
        ('SIN CONVENIO CON EL PROGRAMA SUMAR'),
        ('CON CONVENIO CON EL PROGRAMA SUMAR');");
    }
}
