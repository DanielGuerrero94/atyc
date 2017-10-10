<?php

use Illuminate\Database\Seeder;

class DatosGeograficosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("
        CREATE FOREIGN TABLE IF NOT EXISTS efectores.datos_geograficos
        (
            id_efector integer NOT NULL,
            id_provincia character(2) NOT NULL,
            id_departamento smallint NOT NULL,
            id_localidad smallint NOT NULL,
            ciudad character varying(200),
            created_at timestamp(0) without time zone,
            updated_at timestamp(0) without time zone,
            latitud double precision,
            longitud double precision
        )
        SERVER ".env('SERVER_NAME')." ;");
    }
}
