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
        \DB::statement("INSERT INTO encuestas.encuestas (id_encuesta,id_curso,id_pregunta,id_respuesta,cantidad,
            created_at,updated_at)
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

    /**
     * Busco el ultimo id de la tabla migrada para setear start en la sequence de la nueva tabla.
     *
     * @return void
     */
    public function alterSequence()
    {
        $max_id = \DB::connection('g_plannacer')->select("SELECT max(id) FROM g_plannacer.encuestas");
        $max_id = $max_id[0]->max;
        $max_id++;

        \DB::statement("ALTER SEQUENCE encuestas.encuestas_id_encuesta_seq START ".strval($max_id));
        \DB::statement("ALTER SEQUENCE encuestas.encuestas_id_encuesta_seq RESTART");
    }
}
