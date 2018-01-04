<?php

use Illuminate\Database\Seeder;
use App\Models\Pac\Pauta;

class PautasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $f = fopen(database_path('seeds/pautas.csv'), 'r');

        while (!feof($f)) {
            $line = fgets($f);
            $nombre = '';
            list($id_accion_pauta, $item, $descripcion) = explode(';', $line);
            $descripcion = preg_replace('/\\n/','',$descripcion);
            $anio_vigencia = 2017;
            Pauta::create(compact('item', 'nombre', 'descripcion', 'anio_vigencia', 'id_accion_pauta'));
        }
    }
}
