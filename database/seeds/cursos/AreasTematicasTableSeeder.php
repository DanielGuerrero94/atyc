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
        $this->insert();

        $this->alterSequence();
    }

    /**
     * Migro los datos desde la otra tabla.
     *
     * @return void
     */
    public function insert()
    {
        \DB::statement("INSERT INTO cursos.areas_tematicas(id_area_tematica,nombre) (SELECT sub.id 
            as id_area_tematica,area_tematica as nombre FROM dblink('dbname=elearning port=5432 
            host=192.6.0.66 user=postgres password=BernardoCafe008', 
            'SELECT * FROM g_plannacer.areas_tematicas')    
            AS sub(id integer,area_tematica character varying(200)))");
    }

    /**
     * Busco el ultimo id de la tabla migrada para setear start en la sequence de la nueva tabla.
     *
     * @return void
     */
    public function alterSequence()
    {
        $max_id = \DB::connection('g_plannacer')->select("SELECT max(id) FROM g_plannacer.areas_tematicas");
        $max_id = $max_id[0]->max;
        $max_id++;

        \DB::statement("ALTER SEQUENCE cursos.areas_tematicas_id_area_tematica_seq START ".strval($max_id));
        \DB::statement("ALTER SEQUENCE cursos.areas_tematicas_id_area_tematica_seq RESTART");
    }
}
