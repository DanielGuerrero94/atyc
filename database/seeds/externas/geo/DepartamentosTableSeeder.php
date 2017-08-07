<?php

use Illuminate\Database\Seeder;

class DepartamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("
        CREATE FOREIGN TABLE IF NOT EXISTS geo.departamentos
        (
            id serial NOT NULL,
            id_provincia character(2) NOT NULL,
            id_departamento character(3) NOT NULL,
            nombre_departamento character varying(200) NOT NULL
        )
        SERVER ".env('SERVER_NAME')." ;");
    }
}
