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
        ComponenteCa::create([
            'nombre' => 'INSCRIPCION CON CEB',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'nombre' => 'DESEMPEÑO EN TRAZADORAS',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'nombre' => 'GESTION DE LA INFORMACION Y BdD',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'nombre' => 'ESTRATEGIA DE COMUNICACIÓN Y EMPONDERAMIENTO CIUDADANO',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'nombre' => 'PLAN CON PUEBLOS INDIGENAS',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'nombre' => 'DESEMPEÑO EN CAPACITACIÓN',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'nombre' => 'ESTRATEGRIA DE ESTABLECIMIENTOS PRIORIZADOS',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'nombre' => 'EJECUCION DE FONDOS POR EFECTORES',
            'anio_vigencia' => 2017
        ]);

        ComponenteCa::create([
            'nombre' => 'VALORIZACION Y CONSISTENCIA ECONOMICA-FCIERA DEL PSS',
            'anio_vigencia' => 2017
        ]);
    }
}
