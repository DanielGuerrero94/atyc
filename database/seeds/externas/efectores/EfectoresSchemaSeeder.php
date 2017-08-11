<?php

use Illuminate\Database\Seeder;

class EfectoresSchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EfectoresTableSeeder::class);
        $this->call(DatosGeograficosTableSeeder::class);
        $this->call(DescentralizacionTableSeeder::class);
        $this->call(PriorizadosTableSeeder::class);
        $this->call(ConvenioAdministrativoTableSeeder::class);
    }
}
