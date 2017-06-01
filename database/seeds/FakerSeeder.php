<?php

use Illuminate\Database\Seeder;

class FakerTableSeeder extends Seeder
{

	public function run()
	{
		# code...
	factory(App\User::class, 3)->create();
	factory(App\TipoDocumento::class, 6)->create();
	factory(App\Pais::class, 30)->create();
	factory(App\Provincia::class, 25)->create();
	factory(App\Trabajo::class, 10)->create();
	factory(App\Funcion::class, 10)->create();
	factory(App\Convenio::class, 10)->create();
	factory(App\LineaEstrategica::class, 30)->create();
	factory(App\AreaTematica::class, 30)->create();
	factory(App\Alumno::class, 30)->create();
	factory(App\Profesor::class, 30)->create();
	factory(App\Curso::class, 10)->create();
	}
}
