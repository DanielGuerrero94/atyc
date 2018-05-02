<?php

use Illuminate\Database\Seeder;
use App\Models\Pac\EstadoFichaTecnica;

class EstadoFichaTecnicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoFichaTecnica::create([
            "id_estado_ficha_tecnica" => '1',
            "descripcion" => "No requiere",
            "class" => "bg-aqua"
        ]);

        EstadoFichaTecnica::create([
            "id_estado_ficha_tecnica" => '2',
            "descripcion" => "Requiere completar",
            "class" => "bg-red"
        ]);
        
        EstadoFichaTecnica::create([
            "id_estado_ficha_tecnica" => '3',
            "descripcion" => "Pendiente de aprobación",
            "class" => "bg-yellow"
        ]);
    
        EstadoFichaTecnica::create([
            "id_estado_ficha_tecnica" => '4',
            "descripcion" => "En revisión",
            "class" => "bg-yellow"
        ]);
        
        EstadoFichaTecnica::create([
            "id_estado_ficha_tecnica" => '5',
            "descripcion" => "Aprobado",
            "class" => "bg-green"
        ]);
    }
}
