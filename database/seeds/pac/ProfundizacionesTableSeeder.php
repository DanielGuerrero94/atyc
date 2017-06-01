<?php

use Illuminate\Database\Seeder;

class ProfundizacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO pac.profundizaciones(nombre) values
        	('Divulgacion General'),
        	('Sensibilizacion'),
        	('Nivelacion'),
        	('Capacitacion Especifica')
        	");
    }
}
