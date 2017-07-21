<?php

use Illuminate\Database\Seeder;

class SistemaSchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PaisesTableSeeder::class);
        $this->call(PeriodosTableSeeder::class);
        $this->call(TiposDocumentosTableSeeder::class);
        $this->call(ProvinciasTableSeeder::class);
        $this->call(TiposDocentesTableSeeder::class);
        $this->call(ProfesoresTableSeeder::class);
        $this->call(ReportesTableSeeder::class);
    }
}
