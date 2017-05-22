<?php

use Illuminate\Database\Seeder;

class ProvinciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO sistema.provincias(id_provincia,nombre) 
        (SELECT sub.id,sub.descripcion FROM dblink('dbname=elearning port=5432 
    		host=192.6.0.66 user=postgres password=BernardoCafe008',
    		'SELECT id,descripcion FROM g_plannacer.provincias')
    		AS sub(id integer,
            descripcion character varying(100)))");
    }
}
