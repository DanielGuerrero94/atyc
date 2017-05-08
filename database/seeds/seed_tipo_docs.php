<?php

use Illuminate\Database\Seeder;

class seed_tipo_docs extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        \DB::statement("INSERT INTO public.tipo_docs
           (nombre,titulo) values('DNI','Documento nacional de identidad');");
        \DB::statement("INSERT INTO public.tipo_docs (nombre,titulo) values('LE','Libreta de enrolamiento');");
        \DB::statement("INSERT INTO public.tipo_docs (nombre,titulo) values('LC','Libreta civica');");
        \DB::statement("INSERT INTO public.tipo_docs (nombre,titulo) values('CI','Cedula de identidad');");
        \DB::statement("INSERT INTO public.tipo_docs (nombre,titulo) values('PAS','Pasaporte');");
        \DB::statement("INSERT INTO public.tipo_docs (nombre,titulo) values('DEX','Documento extranjero');");
    }
}






