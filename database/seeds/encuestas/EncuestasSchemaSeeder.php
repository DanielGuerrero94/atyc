<?php

use Illuminate\Database\Seeder;

class EncuestasSchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PreguntasTableSeeder::class);
        $this->call(RespuestasTableSeeder::class);
        $this->call(EncuestasTableSeeder::class);
    }
}
