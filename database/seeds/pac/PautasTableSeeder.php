<?php

use Illuminate\Database\Seeder;
use App\Models\Pac\Pauta;

class PautasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * id_provincia default 25 (UEC)
     * requiere_ficha_tecnica default false
     *
     * @return void
     */
    public function run()
    {
        $this->seeder_2017();
        $this->seeder_2018();
    }

    public function seeder_2017()
    {

        Pauta::create([
            'nombre' => '1.1',
            'descripcion' => 'Planificar acciones de capacitación que tengan como destinatarios a los integrantes de la UGSP, en base a necesidades de Capacitación previamente diagnosticadas y/o solicitadas.',
            'id_categoria_pauta' => 1,
            'item' => 1,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '1.2',
            'descripcion' => 'Diseñar un curso de inducción para los nuevos integrantes del equipo de la UGSP, utilizando la herramienta FICHA TECNICA. Planificar la ejecución del mismo en función de las necesidades detectadas y las demandas recibidas al respecto',
            'id_categoria_pauta' => 1,
            'item' => 2,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '1.3',
            'descripcion' => 'Planificar para los  integrantes de la UGSP la realización del curso de Gestión y Evaluación de Servicios de Salud disponible en la Plataforma de Capacitación a Distancia. (si no lo han hecho previamente)',
            'id_categoria_pauta' => 1,
            'item' => 3,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '2.1',
            'descripcion' => 'Asociar alguna acción de Capacitación a cada objetivo sanitario (ODP)',
            'id_categoria_pauta' => 2,
            'item' => 1,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '2.2',
            'descripcion' => 'Asociar alguna acción de Capacitación a cada objetivo sanitario (ODP) dirigida específicamente a efectores priorizados',
            'id_categoria_pauta' => 2,
            'item' => 2,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '2.3',
            'descripcion' => 'Actividad de institucionalización formativa: activar espacios de formación  e integración sobre el programa Sumar en el marco de las instituciones educativas de la provincia (conceptos principales, sensibilización, visión integral, etc.)',
            'id_categoria_pauta' => 2,
            'item' => 3,
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
            'id_categoria_pauta' => 2,
            'item' => 4,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '3.1',
            'descripcion' => 'Diseñar acciones de capacitación relacionadas con el proceso de inclusión de la población inmigrante al Programa SUMAR',
            'id_categoria_pauta' => 3,
            'item' => 1,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '4.1',
            'descripcion' => 'Diseñar e implementar una accion de capacitación sobre  conceptos generales del programa y conceptos nuevos y/o específicos: CEB, Población objetivo, Plan de Servicios de Salud, Líneas de cuidado, CCC – Cirugía mayor ambulatoria, Débitos y multas en terreno, Trazadoras, Anomalías Congénitas, Enfermedades crónicas no transmisibles, PPAC',
            'id_categoria_pauta' => 4,
            'item' => 1,
            'vigencia' => 2017
        ]);

    }

    public function seeder_2018()
    {

        $id_categoria_pauta = CategoriaPauta::where('item', 1)->where('anio_vigencia', '2018')->first()->id_categoria_pauta;

    Pauta::create([
            'nombre' => '1.1',
            'descripcion' => 'Diseñar un curso de inducción para los nuevos integrantes del equipo de la UGSP Planificar la ejecución del mismo en función de las necesidades detectadas y las demandas recibidas al respecto.',
            'id_categoria_pauta' => $id_categoria_pauta,
            'item' => 1,
            'requiere_ficha_tecnica' => true,
            'vigencia' => 2018
        ]);

        Pauta::create([
            'nombre' => '1.2',
            'descripcion' => 'Planificar acciones de capacitación en base a situaciones de diagnostico específicas.',
            'id_categoria_pauta' => $id_categoria_pauta,
            'item' => 2,
            'vigencia' => 2018
        ]);

        Pauta::create([
            'nombre' => '1.3',
            'descripcion' => 'Planificar para los  integrantes de la UGSP la realización del curso de Gestión y Evaluación de Servicios de Salud disponible en la Plataforma de Capacitación a Distancia. (si no lo han hecho previamente)',
            'id_categoria_pauta' => $id_categoria_pauta,
            'item' => 3,
            'vigencia' => 2018
        ]);

        Pauta::create([
            'nombre' => '1.4',
            'descripcion' => 'diseñar acciones de capacitación relacionadas con la aplicación zoom',
            'id_categoria_pauta' => $id_categoria_pauta,
            'item' => 4,
            'vigencia' => 2018
        ]);

        Pauta::create([
            'nombre' => '1.5',
            'descripcion' => 'Planificar las réplicas de las capacitaciones relacionadas con el sistema de gestión documental electrónica (gde) del ministerio de modernización de la nación',
            'id_categoria_pauta' => $id_categoria_pauta,
            'item' => 5,
            'vigencia' => 2018
        ]);

        Pauta::create([
            'nombre' => '1.6',
            'descripcion' => 'Planificar en conjunto con la UEC, acciones de capacitación relacionadas con el Premio Nacional a la Calidad.',
            'id_categoria_pauta' => $id_categoria_pauta,
            'item' => 6,
            'vigencia' => 2018
        ]);

        Pauta::create([
            'nombre' => '2.1',
            'descripcion' => 'Asociar alguna acción de Capacitación a cada objetivo sanitario (ODP)',
            'id_categoria_pauta' => 2,
            'item' => 1,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '2.2',
            'descripcion' => 'Asociar alguna acción de Capacitación a cada objetivo sanitario (ODP) dirigida específicamente a efectores priorizados',
            'id_categoria_pauta' => 2,
            'item' => 2,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '2.3',
            'descripcion' => 'Actividad de institucionalización formativa: activar espacios de formación  e integración sobre el programa Sumar en el marco de las instituciones educativas de la provincia (conceptos principales, sensibilización, visión integral, etc.)',
            'id_categoria_pauta' => 2,
            'item' => 3,
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
            'id_categoria_pauta' => 2,
            'item' => 4,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '3.1',
            'descripcion' => 'Diseñar acciones de capacitación relacionadas con el proceso de inclusión de la población inmigrante al Programa SUMAR',
            'id_categoria_pauta' => 3,
            'item' => 1,
            'vigencia' => 2017
        ]);

        Pauta::create([
            'nombre' => '4.1',
            'descripcion' => 'Diseñar e implementar una accion de capacitación sobre  conceptos generales del programa y conceptos nuevos y/o específicos: CEB, Población objetivo, Plan de Servicios de Salud, Líneas de cuidado, CCC – Cirugía mayor ambulatoria, Débitos y multas en terreno, Trazadoras, Anomalías Congénitas, Enfermedades crónicas no transmisibles, PPAC',
            'id_categoria_pauta' => 4,
            'item' => 1,
            'vigencia' => 2017
        ]);

    }

}
