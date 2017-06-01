<?php

use Illuminate\Database\Seeder;

class CursosAlumnosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO cursos.cursos_alumnos (id_cursos,id_alumnos,created_at,updated_at)
(SELECT sub.curso,sub.alumno,sub.fecha_registro,sub.fecha_registro
FROM dblink('dbname=elearning port=5432 host=192.6.0.66 user=postgres password=BernardoCafe008','SELECT * FROM g_plannacer.cursos_alumnos')
AS sub(id integer,curso integer,alumno integer,fecha_registro timestamp(0) without time zone))");    
    }
}
