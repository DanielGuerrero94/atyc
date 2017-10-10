<?php

use Illuminate\Database\Seeder;

class AlumnosSchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TrabajosTableSeeder::class);
        $this->call(ConveniosTableSeeder::class);
        $this->call(FuncionesTableSeeder::class);
        $this->call(GenerosTableSeeder::class);
        $this->call(AlumnosTableSeeder::class);

        \DB::statement("update alumnos.funciones set nombre = 'Equipo de salud - Cargo Directivo' 
            where id_funcion = 4;");
        \DB::statement("update alumnos.funciones set nombre = 'Equipo de salud - Profesional de la salud' 
            where id_funcion = 6;");
        \DB::statement("update alumnos.funciones set nombre = 'Equipo de salud - Administrativo' 
            where id_funcion = 3;");
        \DB::statement("update alumnos.funciones set nombre = 'Equipo de salud - Agente Sanitario/Promotor de salud' 
            where id_funcion = 5;");
        \DB::statement("update alumnos.funciones set nombre = 'Equipo integral de la UEC' where id_funcion = 2;");
        \DB::statement("update alumnos.funciones set nombre = 'Equipos de gestion de las UGSP' where id_funcion = 1;");
    }
}
