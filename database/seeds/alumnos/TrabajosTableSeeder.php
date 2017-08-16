<?php

use Illuminate\Database\Seeder;

class TrabajosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {      
        $this->update();
        $this->insert();
    }

    /**
     * Migro los datos desde la otra tabla.
     *
     * @return void
     */
    public function insert()
    {
    	/*
         * Lo dejo aca por si aparece un nuevo tipo de trabajo
         * pero hardcodeo para poder mantener el id de trabajo
         *
         \DB::statement("INSERT INTO alumnos.trabajos(nombre) (SELECT upper(sub.trabaja_en) as nombre FROM dblink('dbname=elearning port=5432 
    		host=192.6.0.66 user=postgres password=BernardoCafe008',
    		'SELECT distinct trabaja_en FROM g_plannacer.alumnos')
    		AS sub(trabaja_en character varying(300)))");*/

        \DB::statement("INSERT INTO alumnos.trabajos (nombre) values
            ('ESTUDIA/SIN TRABAJO FORMAL'),
            ('ESTABLECIMIENTO DE SALUD'),
            ('ORGANISMO GUBERNAMENTAL'),
            ('TRABAJO NO RELACIONADO AL SUMAR')");
    }

    public function update()
    {
        \DB::connection('g_plannacer')->statement("update g_plannacer.alumnos set trabaja_en = 'TRABAJO NO RELACIONADO AL SUMAR' where trabaja_en = 'TRABAJO NO RELACIONADO AL SUMAR - ESTUDIA - NO TRABAJA'"); 
    }
}
