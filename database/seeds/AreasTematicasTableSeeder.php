<?php

use Illuminate\Database\Seeder;

class AreasTematicasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO cursos.areas_tematicas(id_area_tematica,nombre) (SELECT sub.id as id_area_tematica,sub.area_tematica as nombre FROM dblink('dbname=elearning port=5432 
    		host=192.6.0.66 user=postgres password=BernardoCafe008',
    		'SELECT * FROM g_plannacer.areas_tematicas')
    		AS sub(id integer,area_tematica character varying(200)))");
    }
}
