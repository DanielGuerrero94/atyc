<?php

use Illuminate\Database\Seeder;

class seed_funciones extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO public.funcions(nombre) (SELECT sub.funcion as \"nombre\" FROM dblink('dbname=elearning port=5432 
    		host=192.6.0.66 user=postgres password=BernardoCafe008',
    		'SELECT distinct funcion FROM g_plannacer.alumnos')
    		AS sub(funcion character varying(300)))");
    }
}
