<?php

use Illuminate\Database\Seeder;

class RespuestasTableSeeder extends Seeder
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
        *   update g_plannacer.encuestas set respuesta = upper(respuesta)
        */

        \DB::statement("INSERT INTO encuestas.respuestas(descripcion,created_at,updated_at)
        (SELECT
        sub.respuesta,
        now(),
        now()
        FROM dblink('dbname=elearning port=5432 
        host=192.6.0.66 user=postgres password=BernardoCafe008',
        'select respuesta from g_plannacer.encuestas
        group by respuesta
        order by count(*) desc')
        AS sub(respuesta character varying(50)))");        
    }
}
