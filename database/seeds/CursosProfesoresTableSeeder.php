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
        \DB::statement("INSERT INTO cursos.cursos_profesores (id,id_cursos,id_profesores,created_at,updated_at)
(SELECT sub.id,sub.curso,sub.profesor,sub.fecha_registro,sub.fecha_registro
FROM dblink('dbname=elearning port=5432 host=192.6.0.66 user=postgres password=BernardoCafe008','SELECT * FROM g_plannacer.cursos_profesores')
AS sub(id integer,curso integer,profesor integer,fecha_registro timestamp(0) without time zone))");    
    }
}
