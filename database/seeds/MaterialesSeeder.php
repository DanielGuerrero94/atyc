<?php

use Illuminate\Database\Seeder;

class MaterialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Material::create([
	        "id_material" => 11,
	        "path" => "8e63d771fe7613773866c12c2d4ee98f.docx",
	        "original" => "MODELO-Ficha Tecnica-RG ATC N° FT 00X_03.docm",
	   	    "id_etapa" => 2,
	        "orden" => 1,
        ]);
    }
}
