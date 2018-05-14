<?php

use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        var_dump("Seeder deprecated");
        return;
        \DB::statement("INSERT INTO cursos.estados (id_estado,nombre) values
        	(1,'No iniciado'),
        	(2,'En ejecución'),
        	(3,'Terminado'),
        	(4,'Eliminado')
        	");
    }
}
