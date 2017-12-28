<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Corre los seeders en orden.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(SistemaSchemaSeeder::class);
        //$this->call(PublicSchemaSeeder::class);
        $this->call(AlumnosSchemaSeeder::class);
        //$this->call(CursosSchemaSeeder::class);
        //$this->call(EncuestasSchemaSeeder::class);
        $this->call(PacSchemaSeeder::class);
        // $this->call(StoredProceduresSeeder::class);
        //$this->call(ForeignDataWrapperSeeder::class);
        // $this->call(ExternasSeeder::class);
    }

    /*public function run()
    {
        $this->call(FakerTableSeeder::class);
    }*/
}
