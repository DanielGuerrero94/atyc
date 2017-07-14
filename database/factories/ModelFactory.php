<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
	static $password;

	return [
	/* 'name' => substr($faker->name,0,10), */
	'name' => 'usuario'.rand(0,10),
	'email' => $faker->unique()->safeEmail,
	'password' => $password ?: $password = bcrypt('secret'),
	'remember_token' => substr($faker->name,0,40),
	];
});

/** pais */
$factory->define(App\Pais::class, function (Faker\Generator $faker) {
	return [
	'nombre' => $faker->unique()->name
	];
});

/** provincia */
$factory->define(App\Provincia::class, function (Faker\Generator $faker) {
	return [
	'nombre' => substr($faker->unique()->name,0,10)
	];
});

/** tipo documento */
$factory->define(App\TipoDocumento::class, function (Faker\Generator $faker) {
	return [
	'nombre' => substr($faker->unique()->name,0,10),
	'titulo' => substr(substr($faker->name,0,10),0,10)
	];
});

/** trabajo */
$factory->define(App\Trabajo::class, function (Faker\Generator $faker) {
	return [
	'nombre' => $faker->unique()->name
	];
});

/** funciones */
$factory->define(App\Funcion::class, function (Faker\Generator $faker) {
	return [
	'nombre' => $faker->unique()->name
	];
});

/** Convenio */
$factory->define(App\Convenio::class, function (Faker\Generator $faker) {
	return [
	'nombre' => $faker->unique()->name
	];
});

/** linea estrategica */
$factory->define(App\Models\Cursos\LineaEstrategica::class, function (Faker\Generator $faker) {
	return [
	'numero' => substr($faker->name,0,4),
	'nombre' => substr($faker->name,0,4)
	];
});

/** area tematica */
$factory->define(App\Models\Cursos\AreaTematica::class, function (Faker\Generator $faker) {
	return [
	'nombre' => substr($faker->name,0,10)
	];
});

/** alumno */
$factory->define(App\Alumno::class, function (Faker\Generator $faker) {
	return [
	'nombres' => substr($faker->name,0,10),
	'apellidos' => substr($faker->name,0,10),
	'id_tipo_documento' => rand(1,4),
	'nro_doc' => rand(1,20000000),
	'email' => $faker->email,
	'cel' => substr($faker->name,0,10),
	'tel' => substr($faker->name,0,10),
	'localidad' => $faker->address,
	'id_trabajo' => rand(1,4),
	'id_funcion' => rand(1,4),
	'id_provincia' => rand(1,4),
	'id_convenio' => rand(1,4),
	'establecimiento1' => substr($faker->name,0,10),
	'establecimiento2' => substr($faker->name,0,10),
	'organismo1' => substr($faker->name,0,10),
	'organismo2' => substr($faker->name,0,10),
	'id_pais' => rand(1,20)
	];
});

/** profesor */
$factory->define(App\Profesor::class, function (Faker\Generator $faker) {
	return [
	'nombres' => substr($faker->name,0,10),
	'apellidos' => substr($faker->name,0,10),
	'id_tipo_documento' => rand(1,4),
	'nro_doc' => rand(1,20000000),
	'email' => $faker->email,
	'cel' => substr($faker->name,0,10),
	'tel' => substr($faker->name,0,10),
	'id_pais' => rand(1,20)
	];
});

/** curso */
$factory->define(App\Models\Cursos\Curso::class, function (Faker\Generator $faker) {
	return [
	'nombre' => substr($faker->name,0,10),
	'id_provincia' => rand(1,4),
	'id_area_tematica' => rand(1,4),
	'id_linea_estrategica' => rand(1,4),
	'fecha' => $faker->date,
	'duracion' => rand(1,3),
	'edicion' => rand(1,10)
	];
});