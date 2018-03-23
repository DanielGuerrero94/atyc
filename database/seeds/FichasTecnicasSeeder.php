<?php

use Illuminate\Database\Seeder;
use App\Models\Pac\FichaTecnica;
use App\Material;

class FichasTecnicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Antes de que corra esta migracion es necesario la migracion de Material
     * y que exista en la tabla el modelo de ficha tecnica para que el
     * primer ID de este siempre ligado con esa
     *
     * @return void
     */
    public function run()
    {
        $modelo_ficha_tecnica = Material::whereRaw("original ~* 'Modelo'")->first();
        FichaTecnica::create([
            'path' => $modelo_ficha_tecnica->path,
            'original' => $modelo_ficha_tecnica->original
        ]);
    }
}
