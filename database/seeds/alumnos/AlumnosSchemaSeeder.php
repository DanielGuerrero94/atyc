<?php

use Illuminate\Database\Seeder;

class AlumnosSchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {       
        $this->call(TrabajosTableSeeder::class);
        $this->call(ConveniosTableSeeder::class);
        $this->call(FuncionesTableSeeder::class);
        $this->call(AlumnosTableSeeder::class);
    }
}
