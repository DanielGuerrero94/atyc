<?php

use Illuminate\Database\Seeder;

class CursosSchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AreasTematicasTableSeeder::class);
        $this->call(LineasEstrategicasTableSeeder::class);
        $this->call(CursosTableSeeder::class);
        $this->call(CursosAlumnosTableSeeder::class);
        $this->call(CursosProfesoresTableSeeder::class);
    }
}
