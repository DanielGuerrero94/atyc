<?php

use Illuminate\Database\Seeder;

class IndigenasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("
        CREATE FOREIGN TABLE IF NOT EXISTS beneficiarios.indigenas
        (
            clave_beneficiario character varying(16) NOT NULL,
            declara_indigena character(1) NOT NULL,
            id_lengua smallint NOT NULL,
            id_tribu smallint NOT NULL
        )
        SERVER ".env('SERVER_NAME')." ;");
    }
}
