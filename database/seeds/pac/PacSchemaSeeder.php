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
        $this->call(ComponentesCaTableSeeder::class);
        $this->call(CategoriasPautasTableSeeder::class);
        $this->call(PautasTableSeeder::class);
    }
}
