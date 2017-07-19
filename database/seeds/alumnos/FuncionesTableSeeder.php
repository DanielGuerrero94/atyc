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
        \DB::statement("INSERT INTO alumnos.funciones(nombre) (SELECT upper(sub.funcion) as nombre FROM dblink('dbname=elearning port=5432 
          host=192.6.0.66 user=postgres password=BernardoCafe008',
          'SELECT distinct funcion FROM g_plannacer.alumnos')
          AS sub(funcion character varying(300)))");

          \DB::statement("INSERT INTO alumnos.funciones(nombre) values
        ('Autoridades y Equipos tecnicos nacional,provincia y/o municipal'),
        ('Referentes y otros actores comunitarios'),
        ('Comunidad')");      

        \DB::statement("update alumnos.funciones set nombre = 'Equipo de salud - Cargo Directivo' where id_funcion = 4;");

        \DB::statement("update alumnos.funciones set nombre = 'Equipo de salud - Profesional de la salud' where id_funcion = 6;");

        \DB::statement("update alumnos.funciones set nombre = 'Equipo de salud - Administrativo' where id_funcion = 3;");

        \DB::statement("update alumnos.funciones set nombre = 'Equipo de salud - Agente Sanitario/Promotor de salud' where id_funcion = 5;");

        \DB::statement("update alumnos.funciones set nombre = 'Equipo integral de la UEC' where id_funcion = 2;");

        \DB::statement("update alumnos.funciones set nombre = 'Equipos de gestion de las UGSP' where id_funcion = 1;");
    }
}
