<?php

use Illuminate\Database\Seeder;

class EncuestasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO encuestas.encuestas (id_encuesta,id_curso,id_pregunta,id_respuesta,cantidad,created_at,updated_at)
        (SELECT
        sub.id as id_encuesta, 
        sub.curso as id_curso,
        p.id_pregunta as id_pregunta,
        r.id_respuesta as id_respuesta,
        sub.cantidad,
        now(),
        now()
        FROM dblink('dbname=elearning port=5432 
     	host=192.6.0.66 user=postgres password=BernardoCafe008',
     	'SELECT id,curso,pregunta,respuesta,cantidad FROM g_plannacer.encuestas')
     	AS sub(
     	id integer,
        curso integer,
        pregunta character varying(100),
        respuesta character varying(50),
        cantidad integer)
        INNER JOIN encuestas.preguntas p on p.descripcion = sub.pregunta
        INNER JOIN encuestas.respuestas r on r.descripcion = sub.respuesta)");
    }
}
