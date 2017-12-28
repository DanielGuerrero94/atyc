<?php

use Illuminate\Database\Seeder;
use App\Models\Cursos\Estado;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Estado::create(['nombre' => 'NO INICIADO']);
    	Estado::create(['nombre' => 'EN EJECUCION']);
    	Estado::create(['nombre' => 'TERMINADO']);
    	Estado::create(['nombre' => 'ELIMINADO']);
    	Estado::create(['nombre' => 'REPROGRAMADO']);
    }
}
