<?php

use Illuminate\Database\Seeder;

class ProvinciasIndecTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("
        CREATE FOREIGN TABLE IF NOT EXISTS geo.provincias
        (
            id_provincia character(2) NOT NULL,
            id_region integer NOT NULL,
            descripcion character varying(100) NOT NULL,
            latlong character varying(100) NOT NULL
        )
        SERVER ".env('SERVER_NAME')." ;");
    }
}
