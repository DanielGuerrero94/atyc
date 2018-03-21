<?php

use Illuminate\Database\Seeder;
use App\Models\Pac\CategoriaPauta;

class CategoriasPautasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaPauta::create([
            'item' => 1,
            'nombre' => 'Categoria: 1',
            'descripcion' => 'ACCIONES DE CAPACITACIÓN PARA EL EQUIPO DE LA UGSP',
            'anio_vigencia' => 2017
        ]);

        CategoriaPauta::create([
            'item' => 2,
            'nombre' => 'Categoria: 2',
            'descripcion' => 'ACCIONES DE CAPACITACIÓN QUE CONSIDEREN LAS ESTRATEGIAS ORGANIZACIONALES',
            'anio_vigencia' => 2017
        ]);

        CategoriaPauta::create([
            'item' => 3,
            'nombre' => 'Categoria: 3',
            'descripcion' => 'ACCIONES DE CAPACITACIÓN PARA EL ACOMPAÑAMIENTO DE LA IMPLEMENTACIÓN DEL PROGRAMA',
            'anio_vigencia' => 2017
        ]);

        CategoriaPauta::create([
            'item' => 4,
            'nombre' => 'Categoria: 4',
            'descripcion' => 'ACCIONES DE CAPACITACIÓN PARA EL ACOMPAÑAMIENTO DE LA IMPLEMENTACIÓN DEL PROGRAMA',
            'anio_vigencia' => 2017
        ]);

        CategoriaPauta::create([
            'item' => 5,
            'nombre' => 'Categoria: 5',
            'descripcion' => 'ACCIONES DE CAPACITACIÓN A DISTANCIA',
            'anio_vigencia' => 2017
        ]);

        CategoriaPauta::create([
            'item' => 6,
            'nombre' => 'Categoria: 6',
            'descripcion' => 'GESTIÓN DE MATERIALES DE CAPACITACIÓN',
            'anio_vigencia' => 2017
        ]);

        CategoriaPauta::create([
            'item' => 7,
            'nombre' => 'Categoria: 7',
            'descripcion' => 'ACCIONES DE CAPACITACIÓN PARA CONTRIBUIR AL CUMPLIMIENTO DEL INDICADOR CONJUNTO  CON EL ÁREA DE COMUNICACIÓN DEL COMPROMISO ANUAL',
            'anio_vigencia' => 2017
        ]);

        CategoriaPauta::create([
            'item' => 8,
            'nombre' => 'Categoria: 8',
            'descripcion' => 'ACCIONES DE CAPACITACIÓN ESPECÍFICAS PARA LOS RESPONSABLES DE CAPACITACIÓN Y PUEBLOS INDÍGENAS DE LA UGSP',
            'anio_vigencia' => 2017
        ]);

        CategoriaPauta::create([
            'item' => 9,
            'nombre' => 'Categoria: 9',
            'descripcion' => 'ACCIONES DE CAPACITACIÓN PARA FORTALECER LAS SALVAGUARDAS DEL PROGRAMA',
            'anio_vigencia' => 2017
        ]);

        CategoriaPauta::create([
            'item' => 10,
            'nombre' => 'Categoria: 10',
            'descripcion' => 'ACCIONES DE CAPACITACIÓN QUE CONSIDEREN LAS ESTRATEGIAS ORGANIZACIONALES  ESPECÍFICAS DE CADA UGSP',
            'anio_vigencia' => 2017
        ]);
    }
}
