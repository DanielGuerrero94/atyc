<?php

use Illuminate\Database\Seeder;
use App\Models\Pac\PacEstado;

class PacEstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PacEstado::updateOrCreate([
            'id_estado' => PacEstado::ACCION_NUEVA
        ], [
            'nombre'    => 'Acción Nueva',
        ]);

        PacEstado::updateOrCreate([
            'id_estado' => PacEstado::ACCION_EN_REVISION
        ], [
            'nombre'    => 'Acción en Revisión',
        ]);

        PacEstado::updateOrCreate([
            'id_estado' => PacEstado::ACCION_APROBADA
        ], [
            'nombre'    => 'Acción Aprobada',
        ]);

        PacEstado::updateOrCreate([
            'id_estado' => PacEstado::ACCION_RECHAZADA
        ], [
            'nombre'    => 'Acción Rechazada',
        ]);
    }
}
