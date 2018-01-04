<?php

use Illuminate\Database\Seeder;

class CategoriasPautasSeeder extends Seeder
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
            $nombre = preg_replace('/\\n/','',$nombre);
            $descripcion = '';
            $anio_vigencia = 2017;
            AccionesPautas::create(compact('item', 'nombre', 'descripcion', 'anio_vigencia'));
        }
        
    }
}
