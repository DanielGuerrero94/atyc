<?php

use Illuminate\Database\Seeder;

class FuncionesTableSeeder extends Seeder
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
        \DB::statement("INSERT INTO alumnos.funciones(nombre) (SELECT upper(sub.funcion) as nombre FROM 
            dblink('dbname=elearning port=5432 
          host=192.6.0.66 user=postgres password=BernardoCafe008',
          'SELECT distinct funcion FROM g_plannacer.alumnos')
          AS sub(funcion character varying(300)))");

          \DB::statement("INSERT INTO alumnos.funciones(nombre) values
        ('Autoridades y Equipos tecnicos nacional,provincia y/o municipal'),
        ('Referentes y otros actores comunitarios'),
        ('Comunidad')");
    }
}
