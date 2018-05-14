<?php

use Illuminate\Database\Seeder;
use App\Models\Pac\ComponenteCa;

class ComponentesCaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed_2017();
        $this->seed_2018();
    }
        
    public function seed_2017()
    {

        ComponenteCa::create([
            'item' => 1,
            'nombre' => 'INSCRIPCION CON CEB',
            'anio_vigencia' => '2017'
        ]);

        ComponenteCa::create([
            'item' => 2,
            'nombre' => 'DESEMPEÑO EN TRAZADORAS',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'item' => 3,
            'nombre' => 'GESTION DE LA INFORMACION Y BdD',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'item' => 4,
            'nombre' => 'ESTRATEGIA DE COMUNICACIÓN Y EMPONDERAMIENTO CIUDADANO',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'item' => 5,
            'nombre' => 'PLAN CON PUEBLOS INDIGENAS',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'item' => 6,
            'nombre' => 'DESEMPEÑO EN CAPACITACIÓN',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'item' => 7,
            'nombre' => 'ESTRATEGIA DE ESTABLECIMIENTOS PRIORIZADOS',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'item' => 8,
            'nombre' => 'EJECUCION DE FONDOS POR EFECTORES',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'item' => 9,
            'nombre' => 'VALORIZACION Y CONSISTENCIA ECONOMICA-FCIERA DEL PSS',
            'anio_vigencia' => 2017
        ]);

    }

    public function seed_2018() {

        ComponenteCa::create([
            'item' => 1,
            'nombre' => 'INSCRIPCION CON CEB',
            'anio_vigencia' => 2018
        ]);

        ComponenteCa::create([
            'item' => 2,
            'nombre' => 'DESEMPEÑO EN TRAZADORAS',
            'anio_vigencia' => 2018
        ]);

        ComponenteCa::create([
            'item' => 3,
            'nombre' => 'GESTION DE LA INFORMACION Y BdD',
            'anio_vigencia' => 2018
        ]);

        ComponenteCa::create([
            'item' => 4,
            'nombre' => 'ESTRATEGIA DE COMUNICACIÓN Y EMPONDERAMIENTO CIUDADANO',
            'anio_vigencia' => 2018
        ]);

        ComponenteCa::create([
            'item' => 5,
            'nombre' => 'PLAN CON PUEBLOS INDIGENAS',
            'anio_vigencia' => 2018
        ]);

        ComponenteCa::create([
            'item' => 6,
            'nombre' => 'DESEMPEÑO EN CAPACITACIÓN',
            'anio_vigencia' => 2018
        ]);

        ComponenteCa::create([
            'item' => 7,
            'nombre' => 'ESTRATEGIA DE ESTABLECIMIENTOS PRIORIZADOS PRIORIZADOS PARA GESTION X RDOS',
            'anio_vigencia' => 2018
        ]);

        ComponenteCa::create([
            'item' => 8,
            'nombre' => 'ASIGNACION DE POBLACION A CARGO',
            'anio_vigencia' => 2018
        ]);

        ComponenteCa::create([
            'item' => 9,
            'nombre' => 'VALORIZACION Y CONSISTENCIA ECONOMICA-FINANCIERA DEL PSS',
            'anio_vigencia' => 2018
        ]);

    }
}
