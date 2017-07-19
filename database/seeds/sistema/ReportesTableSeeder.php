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
        ('ODP Int.4 \"Número total de staff institucional que participó de

actividades de capacitación con más de 10 horas acumuladas\"','acumula-10-horas'),
        ('banco-acumula-10-horas','banco-acumula-10-horas'),
        ('\"Porcentaje de efectores capacitados con modalidad presencial\"','alguna-actividad'),
        ('porcentaje-establecimientos','porcentaje-establecimientos'),
        ('cursos-cantidad-alumnos','cursos-cantidad-alumnos'),
        ('grado-satisfaccion','grado-satisfaccion')");        
    }
}
