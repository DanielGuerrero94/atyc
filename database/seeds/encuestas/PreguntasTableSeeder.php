<?php

use Illuminate\Database\Seeder;

class PreguntasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
        *   Correr antes de migrar
        *   update g_plannacer.encuestas set pregunta = upper(pregunta)
        */

        \DB::connection('g_plannacer')->statement('update g_plannacer.encuestas set pregunta = upper(pregunta)');

        \DB::statement("INSERT INTO encuestas.preguntas(descripcion,created_at,updated_at)
        (SELECT
        sub.pregunta as descripcion,
        now(),
        now()
        FROM dblink('dbname=elearning port=5432 
        host=192.6.0.66 user=postgres password=BernardoCafe008',
        'select pregunta from g_plannacer.encuestas
        group by pregunta
        order by count(*) desc')
        AS sub(pregunta character varying(100)))");
    }
}
