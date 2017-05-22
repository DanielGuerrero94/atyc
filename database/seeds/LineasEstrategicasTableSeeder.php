<?php

use Illuminate\Database\Seeder;

class LineasEstrategicasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO cursos.lineas_estrategicas(id_linea_estrategica,numero,nombre) 
        (SELECT sub.id as id_linea_estrategica,substring(sub.lineas_estrategicas,7,3) as numero,substring(sub.lineas_estrategicas,13) as nombre 
        FROM dblink('dbname=elearning port=5432 
    		host=192.6.0.66 user=postgres password=BernardoCafe008',
    		'SELECT id,lineas_estrategicas FROM g_plannacer.lineas_estrategicas')
    		AS sub(id integer,lineas_estrategicas character varying(500)))");
    }
}
