<?php

use Illuminate\Database\Seeder;

class GeoSchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DepartamentosTableSeeder::class);
        $this->call(LocalidadesTableSeeder::class);
        $this->call(ProvinciasIndecTableSeeder::class);
    }
}
