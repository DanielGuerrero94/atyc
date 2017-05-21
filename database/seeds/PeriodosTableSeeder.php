<?php

use Illuminate\Database\Seeder;

class PeriodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO sistema.periodos
       (nombre,desde,hasta)
       (SELECT
       sub.descripcion as nombre, 
       sub.fecha_desde as desde,
       sub.fecha_hasta as hasta
       FROM dblink('dbname=elearning port=5432 
       host=192.6.0.66 user=postgres password=BernardoCafe008',
       'SELECT * FROM g_plannacer.periodos')
       AS sub(id integer,
       descripcion character varying(250),
       fecha_desde timestamp without time zone,
       fecha_hasta timestamp without time zone))");
    }
}
