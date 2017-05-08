<?php

use Illuminate\Database\Seeder;

class seed_convenios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO public.convenios
         (nombre) values('');");
        \DB::statement("INSERT INTO public.convenios
         (nombre) values('SIN CONVENIO CON EL PROGRAMA SUMAR');");
        \DB::statement("INSERT INTO public.convenios
         (nombre) values('CON CONVENIO CON EL PROGRAMA SUMAR');");
    }
}
