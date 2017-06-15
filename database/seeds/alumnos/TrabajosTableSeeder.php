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
        $this->insert();
    }

    /**
     * Migro los datos desde la otra tabla.
     *
     * @return void
     */
    public function insert()
    {
    	\DB::statement("INSERT INTO alumnos.trabajos(nombre) (SELECT upper(sub.trabaja_en) as nombre FROM dblink('dbname=elearning port=5432 
    		host=192.6.0.66 user=postgres password=BernardoCafe008',
    		'SELECT distinct trabaja_en FROM g_plannacer.alumnos')
    		AS sub(trabaja_en character varying(300)))");
    }
}
