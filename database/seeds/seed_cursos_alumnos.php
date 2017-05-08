<?php

use Illuminate\Database\Seeder;

class seed_cursos_alumnos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO public.cursos_alumnos (id,id_cursos,id_alumnos,created_at)
(SELECT sub.id,sub.curso,sub.alumno,sub.fecha_registro
FROM dblink('dbname=elearning port=5432 host=192.6.0.66 user=postgres password=BernardoCafe008','SELECT * FROM g_plannacer.cursos_alumnos')
AS sub(id integer,curso integer,alumno integer,fecha_registro timestamp(0) without time zone))");
    
    }
}
