<?php

use Illuminate\Database\Seeder;
use App\Models\Cursos\Modalidad;
use Illuminate\Support\Facades\DB;

class ModalidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modalidad::updateOrCreate([
            'id_modaliad' => Modalidad::PRESENCIAL
        ], [
            'nombre' => 'PRESENCIAL',
        ]);

        Modalidad::updateOrCreate([
            'id_modaliad' => Modalidad::VIRTUAL
        ], [
            'nombre' => 'VIRTUAL',
        ]);

        Modalidad::updateOrCreate([
            'id_modaliad' => Modalidad::DISPOSITIVO_TEXTO
        ], [
            'nombre' => 'DISPOSITIVO DE TEXTO',
        ]);

        $maxModalidadId = Modalidad::max('id_modalidad') + 1;

        DB::statement("ALTER SEQUENCE modalidades_id_modalidad_seq restart with {$maxModalidadId};");
    }
}
