<?php

use Illuminate\Database\Seeder;

class ModalidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO pac.modalidades(nombre) values
        	('Presencial'),
        	('Semipresencial'),
        	('A distancia\(virtual\)'),
        	('Espacio de Entrenamiento')
        	");
    }
}
