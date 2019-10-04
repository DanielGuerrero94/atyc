<?php

use Illuminate\Database\Seeder;

class EtapasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\DB::statement("INSERT INTO sistema.etapas (id_etapa, nombre) values 
    		(1, 'Diagnóstico'),
    		(2, 'Diseño'),
    		(3, 'Planificación'),
    		(4, 'Ejecución'),
    		(5, 'Evaluación'),
    		(6, 'Monitoreo')");
    }
}
