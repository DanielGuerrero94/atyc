<?php

use Illuminate\Database\Seeder;

class DescentralizacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        \DB::statement("
        CREATE FOREIGN TABLE IF NOT EXISTS efectores.descentralizacion
        (
            id_efector integer NOT NULL,
            internet character(1) NOT NULL DEFAULT 'N'::bpchar,
            factura_descentralizada character(1) NOT NULL DEFAULT 'N'::bpchar,
            factura_on_line character(1) NOT NULL DEFAULT 'N'::bpchar
        )
        SERVER ".env('SERVER_NAME')." ;");
    }
}
