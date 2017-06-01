<?php

use Illuminate\Database\Seeder;

class ReportesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO sistema.reportes(nombre,view) values
        ('acumula-10-horas','acumula-10-horas'),
        ('banco-acumula-10-horas','banco-acumula-10-horas'),
        ('alguna-actividad','alguna-actividad'),
        ('porcentaje-establecimientos','porcentaje-establecimientos'),
        ('cursos-cantidad-alumnos','cursos-cantidad-alumnos'),
        ('grado-satisfaccion','grado-satisfaccion')");        
    }
}
