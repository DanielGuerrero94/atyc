<?php

use Illuminate\Database\Seeder;
use App\Models\Pac\AccionPauta;

class CategoriasPautasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $f = fopen(database_path('seeds/categoriasPautas.csv'), 'r');

        while (!feof($f)) {
            $line = fgets($f);
            list($item, $nombre) = explode(';', $line);
            $descripcion = '';
            $anio_vigencia = 2017;
            AccionPauta::create(compact('item', 'nombre', 'descripcion', 'anio_vigencia'));
        }
        
    }
}
