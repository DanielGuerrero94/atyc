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
        \DB::statement("INSERT INTO cursos.cursos_alumnos (id_curso,id_alumno,created_at,updated_at)
(SELECT sub.curso,sub.alumno,sub.fecha_acreditacion,sub.fecha_acreditacion
FROM dblink('dbname=elearning port=5432 host=192.6.0.66 user=postgres password=BernardoCafe008','SELECT curso,alumno,fecha_acreditacion FROM g_plannacer.cursos_alumnos')AS sub(curso integer,alumno integer,fecha_acreditacion timestamp(0) without time zone))");    
    }
}
