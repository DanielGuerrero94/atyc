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

actividades de capacitación con más de 10 horas acumuladas\"','odp4'),
        ('Reporte banco','banco-acumula-10-horas'),
        ('Total staff institucional','total-staff-institucional'),
        ('Porcentaje de efectores capacitados con modalidad presencial','porcentaje-efectores'),
        ('Cantidad de participantes por acción de capacitación','cursos-cantidad-alumnos'),
        ('Grado de satisfaccion de los participates','grado-satisfaccion')");        
    }
}      