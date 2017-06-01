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
	'name' => $faker->name,
	'email' => $faker->unique()->safeEmail,
	'password' => $password ?: $password = bcrypt('secret'),
	'remember_token' => str_random(10),
	];
});

/** pais */
$factory->define(App\Provincia::class, function (Faker\Generator $faker) {
	return [
	'nombre' => $faker->unique()->name
	];
});

/** provincia */
$factory->define(App\Provincia::class, function (Faker\Generator $faker) {
	return [
	'nombre' => $faker->unique()->name
	];
});

/** tipo documento */
$factory->define(App\TipoDocumento::class, function (Faker\Generator $faker) {
	return [
	'nombre' => $faker->unique()>name,
	'titulo' => $faker->name
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
$factory->define(App\LineaEstrategica::class, function (Faker\Generator $faker) {
	return [
	'numero' => str_random(10),
	'nombre' => $faker->name
	];
});

/** area tematica */
$factory->define(App\AreaTematica::class, function (Faker\Generator $faker) {
	return [
	'nombre' => $faker->name
	];
});

/** alumno */
$factory->define(App\Alumno::class, function (Faker\Generator $faker) {
	return [
	'nombres' => $faker->name,
	'apellidos' => $faker->name,
	'id_tipo_documento' => random(4),
	'nro_doc' => random(20000000),
	'email' => $faker->email,
	'cel' => $faker->name,
	'tel' => $faker->name,
	'localidad' => $faker->address,
	'id_trabajo' => random(4),
	'id_funcion' => random(4),
	'id_provincia' => random(4),
	'id_convenio' => random(4),
	'establecimiento1' => $faker->name,
	'establecimiento2' => $faker->name,
	'organismo1' => $faker->name,
	'organismo2' => $faker->name,
	'id_pais' => random(20)
	];
});

/** profesor */
$factory->define(App\Profesor::class, function (Faker\Generator $faker) {
	return [
	'nombres' => $faker->name,
	'apellidos' => $faker->name,
	'id_tipo_documento' => random(4),
	'nro_doc' => random(20000000),
	'email' => $faker->email,
	'cel' => $faker->name,
	'tel' => $faker->name,
	'id_pais' => random(20)
	];
});

/** curso */
$factory->define(App\Alumno::class, function (Faker\Generator $faker) {
	return [
	'nombres' => $faker->name,
	'id_provincia' => random(4),
	'id_area_tematica' => random(4),
	'id_linea_estrategica' => random(4),
	'fecha' => $faker->date,
	'duracion' => random(3),
	'edicion' => random(10)
	];
});