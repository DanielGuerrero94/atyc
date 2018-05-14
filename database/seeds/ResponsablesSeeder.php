<?php

use Illuminate\Database\Seeder;
use App\Models\Cursos\Responsable;

class ResponsablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Responsable::create([
            'nombre' => 'UGSP'
        ]);

        Responsable::create([
            'nombre' => 'UEC - ATyC'
        ]);

        Responsable::create([
            'nombre' => 'UEC - OTRAS AREAS'
        ]);

        Responsable::create([
            'nombre' => 'OTROS PROGRAMAS PROV O NAC'
        ]);
     }
}
