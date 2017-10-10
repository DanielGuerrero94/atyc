<?php

use Illuminate\Database\Seeder;

class PriorizadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("
        CREATE FOREIGN TABLE IF NOT EXISTS efectores.priorizados
        (
            id_provincia character(2) NOT NULL,
            cuie character(6) NOT NULL,
            fecha date NOT NULL
        )
        SERVER ".env('SERVER_NAME')." ;");
    }
}
