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
            'id_modalidad' => Modalidad::PRESENCIAL
        ], [
            'nombre' => 'PRESENCIAL',
        ]);

        Modalidad::updateOrCreate([
            'id_modalidad' => Modalidad::VIRTUAL
        ], [
            'nombre' => 'VIRTUAL',
        ]);

        Modalidad::updateOrCreate([
            'id_modalidad' => Modalidad::DISPOSITIVO_TEXTO
        ], [
            'nombre' => 'DISPOSITIVO DE TEXTO',
        ]);

        $maxModalidadId = Modalidad::max('id_modalidad') + 1;

        DB::statement("ALTER SEQUENCE cursos.modalidades_id_modalidad_seq restart with {$maxModalidadId};");
    }
}
