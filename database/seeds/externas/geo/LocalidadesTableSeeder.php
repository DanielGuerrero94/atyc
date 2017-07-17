<?php

use Illuminate\Database\Seeder;

class LocalidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("
        CREATE FOREIGN TABLE IF NOT EXISTS geo.localidades
        (
            id serial NOT NULL,
            id_provincia character(2) NOT NULL,
            id_departamento character(3) NOT NULL,
            id_localidad character varying(5) NOT NULL,
            nombre_localidad character varying(200) NOT NULL
        )
        SERVER ".env('SERVER_NAME')." ;");
    }
}
