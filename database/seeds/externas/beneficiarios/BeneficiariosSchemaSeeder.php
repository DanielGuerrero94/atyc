<?php

use Illuminate\Database\Seeder;

class BeneficiariosSchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BeneficiariosTableSeeder::class);
        $this->call(IndigenasTableSeeder::class);
    }
}
