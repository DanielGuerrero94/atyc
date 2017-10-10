<?php

use Illuminate\Database\Seeder;

class ExternasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BeneficiariosSchemaSeeder::class);
        $this->call(EfectoresSchemaSeeder::class);
        $this->call(GeoSchemaSeeder::class);
    }
}
