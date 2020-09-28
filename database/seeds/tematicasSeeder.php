<?php

use Illuminate\Database\Seeder;

class tematicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT into pac.tematicas (nombre) values
('ODP'),
('Trazadoras'),
('Poblaciones Indígenas - Interculturalidad en Salud'),
('Facturación'),
('Prestaciones Priorizadas'),
('PSS'),
('Uso de Fondos'),
('Estrategia de gestión de metas y desempeños con establecimientos públicos de salud'),
('Población Objetivo'),
('Débitos y Multas en terreno'),
('Inmunizaciones'),
('Registro de HC y atributos de calidad'),
('Organización y realización de talleres'),
('Enfermedades crónicas no transmisibles'),
('Salvaguarda Ambiental'),
('Población migrantes'),
('Competencias de habilidades y conducta'),
('Competencias de gestión en salud  '),
('Promoción y prevención de la salud y abordaje desde una perspectiva de derechos'),
('Géneros'),
('Coronavirus'),
('Mejora Continua'),
('Dbt'),
('Infarto'),
('Otra Temática');");
    }
}
