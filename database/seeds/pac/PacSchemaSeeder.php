<?php

use Illuminate\Database\Seeder;

class PacSchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ModalidadesTableSeeder::class);
        $this->call(ProfundizacionesTableSeeder::class);
        $this->call(AlcancesTableSeeder::class);
        $this->call(DestinatariosTableSeeder::class);
    }
}
