<?php

use Illuminate\Database\Seeder;

class TiposDocumentosTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        \DB::statement("INSERT INTO sistema.tipos_documentos(nombre,titulo) values
            ('DNI','Documento nacional de identidad'),
            ('LE','Libreta de enrolamiento'),
            ('LC','Libreta civica'),
            ('CI','Cedula de identidad'),
            ('PAS','Pasaporte'),
            ('DEX','Documento extranjero');");
    }
}






