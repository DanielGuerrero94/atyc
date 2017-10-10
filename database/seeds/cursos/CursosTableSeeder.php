<?php

use Illuminate\Database\Seeder;

class CursosTableSeeder extends Seeder
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
        \DB::statement("INSERT INTO cursos.cursos
            (id_curso,nombre,id_provincia,id_area_tematica,id_linea_estrategica,fecha,duracion,edicion,created_at,
            updated_at)
            (SELECT
            sub.id, 
            sub.nombre_curso,
            sub.provincia_organizadora,
            sub.area_tematica,
            sub.linea_estrategica,
            sub.fecha_curso,
            sub.horas_duracion,
            sub.edicion,
            now(),
            now()
            FROM dblink('dbname=elearning port=5432 
            host=192.6.0.66 user=postgres password=BernardoCafe008',
            'SELECT id,nombre_curso,provincia_organizadora,area_tematica,linea_estrategica,fecha_curso,horas_duracion,
            edicion FROM g_plannacer.cursos')
            AS sub(id integer,
            nombre_curso character varying(250),
            provincia_organizadora integer,
            area_tematica integer,
            linea_estrategica integer,
            fecha_curso timestamp(0) without time zone,
            horas_duracion integer,
            edicion integer))");
    }

    /**
     * Busco el ultimo id de la tabla migrada para setear start en la sequence de la nueva tabla.
     *
     * @return void
     */
    public function alterSequence()
    {
        $max_id = \DB::connection('g_plannacer')->select("SELECT max(id) FROM g_plannacer.cursos");
        $max_id = $max_id[0]->max;
        $max_id++;

        \DB::statement("ALTER SEQUENCE cursos.cursos_id_curso_seq START ".strval($max_id));
        \DB::statement("ALTER SEQUENCE cursos.cursos_id_curso_seq RESTART");
    }
}
