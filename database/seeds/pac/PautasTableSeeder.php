<?php

use Illuminate\Database\Seeder;
use App\Models\Pac\Pauta;

class PautasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pauta::create([
            'nombre' => '1.1',
            'descripcion' => 'Planificar acciones de capacitación que tengan como destinatarios a los integrantes de la UGSP, en base a necesidades de Capacitación previamente diagnosticadas y/o solicitadas.',
            'id_categoria_pauta' => 13,
            'item' => 1,
            'id_provincia' => 25,
            'requiere_ficha_tecnica' => false,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '1.2',
            'descripcion' => 'Diseñar un curso de inducción para los nuevos integrantes del equipo de la UGSP, utilizando la herramienta FICHA TECNICA. Planificar la ejecución del mismo en función de las necesidades detectadas y las demandas recibidas al respecto',
            'id_categoria_pauta' => 13,
            'item' => 2,
            'id_provincia' => 25,
            'requiere_ficha_tecnica' => false,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '1.3',
            'descripcion' => 'Planificar para los  integrantes de la UGSP la realización del curso de Gestión y Evaluación de Servicios de Salud disponible en la Plataforma de Capacitación a Distancia. (si no lo han hecho previamente)',
            'id_categoria_pauta' => 13,
            'item' => 3,
            'id_provincia' => 25,
            'requiere_ficha_tecnica' => false,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '2.1',
            'descripcion' => 'Asociar alguna acción de Capacitación a cada objetivo sanitario (ODP)',
            'id_categoria_pauta' => 14,
            'item' => 1,
            'id_provincia' => 25,
            'requiere_ficha_tecnica' => false,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '2.2',
            'descripcion' => 'Asociar alguna acción de Capacitación a cada objetivo sanitario (ODP) dirigida específicamente a efectores priorizados',
            'id_categoria_pauta' => 14,
            'item' => 2,
            'id_provincia' => 25,
            'requiere_ficha_tecnica' => false,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '2.3',
            'descripcion' => 'Actividad de institucionalización formativa: activar espacios de formación  e integración sobre el programa Sumar en el marco de las instituciones educativas de la provincia (conceptos principales, sensibilización, visión integral, etc.)',
            'id_categoria_pauta' => 14,
            'item' => 3,
            'id_provincia' => 25,
            'requiere_ficha_tecnica' => false,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '2.4',
            'descripcion' => 'Relevar y registrar en el Espacio de intercambio de experiencias SUMAR de la Plataforma de Capacitación a Distancia las siguientes experiencias:
                o Banco de proyectos desarrollados por los participantes del Programa de Formación “SUMAR Conocimiento y Liderazgo”
                o Banco de Buenas Prácticas relacionadas con la gestión de los servicios de salud
                o Banco de Experiencias de Participación Comunitaria en la implementación del Programa SUMAR
                o Banco de Experiencias destacadas por aportes de Personas, Equipos de trabajo y Organizaciones al Programa SUMAR
                o Banco de Experiencias destacadas con Poblaciones Indígenas
                http://www.capacitacionsumar.msal.gov.ar/

                *Con respecto a esta pauta, próximamanete recibirán más información en relación a la estrategia del CUS - Sumar en Calidad, para la cual este relevamiento es un insumo para su implementación',
            'id_categoria_pauta' => 14,
            'item' => 4,
            'id_provincia' => 25,
            'requiere_ficha_tecnica' => false,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '3.1',
            'descripcion' => 'Diseñar acciones de capacitación relacionadas con el proceso de inclusión de la población inmigrante al Programa SUMAR',
            'id_categoria_pauta' => 15,
            'item' => 1,
            'id_provincia' => 25,
            'requiere_ficha_tecnica' => false,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '4.1',
            'descripcion' => 'Diseñar e implementar una accion de capacitación sobre  conceptos generales del programa y conceptos nuevos y/o específicos: CEB, Población objetivo, Plan de Servicios de Salud, Líneas de cuidado, CCC – Cirugía mayor ambulatoria, Débitos y multas en terreno, Trazadoras, Anomalías Congénitas, Enfermedades crónicas no transmisibles, PPAC',
            'id_categoria_pauta' => 16,
            'item' => 1,
            'id_provincia' => 25,
            'requiere_ficha_tecnica' => false,
            'vigencia' => 2017
        ]);
    }
}
