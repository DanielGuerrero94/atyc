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
        \DB::statement("INSERT INTO sistema.reportes(id_reporte,nombre,view) values
        (1,'acumula-10-horas','acumula-10-horas'),
        (2,'banco-acumula-10-horas','banco-acumula-10-horas'),
        (3,'alguna-actividad','alguna-actividad'),
        (4,'porcentaje-establecimientos','porcentaje-establecimientos'),
        (5,'cursos-cantidad-alumnos','cursos-cantidad-alumnos'),
        (6,'grado-satisfaccion','grado-satisfaccion')");        
    }
}
