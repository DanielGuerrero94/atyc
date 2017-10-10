<?php

use Illuminate\Database\Seeder;

class CursosProfesoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO cursos.cursos_profesores (id_curso,id_profesor,created_at,updated_at)
(SELECT sub.curso,sub.profesor,sub.fecha_registro,sub.fecha_registro
FROM dblink('dbname=elearning port=5432 host=192.6.0.66 user=postgres password=BernardoCafe008',
'SELECT curso,profesor,fecha_registro FROM g_plannacer.cursos_profesores')
AS sub(curso integer,profesor integer,fecha_registro timestamp(0) without time zone))");
    }
}
