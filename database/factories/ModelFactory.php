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
        'name' => 'usuario'.rand(0, 10),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => substr($faker->name, 0, 40),
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
        'nombre' => substr($faker->unique()->name, 0, 10)
    ];
});

/** tipo documento */
$factory->define(App\TipoDocumento::class, function (Faker\Generator $faker) {
    return [
        'nombre' => substr($faker->unique()->name, 0, 10),
        'titulo' => substr(substr($faker->name, 0, 10), 0, 10)
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
        'numero' => substr($faker->unique()->name, 0, 4),
        'nombre' => substr($faker->unique()->name, 0, 4)
    ];
});

/** area tematica */
$factory->define(App\Models\Cursos\AreaTematica::class, function (Faker\Generator $faker) {
    return [
        'nombre' => substr($faker->name, 0, 10)
    ];
});

/** alumno */
$factory->define(App\Alumno::class, function (Faker\Generator $faker) {
    return [
        'nombres' => substr($faker->name, 0, 10),
        'apellidos' => substr($faker->name, 0, 10),
        'id_tipo_documento' => rand(1, 4),
        'nro_doc' => rand(1, 20000000),
        'email' => $faker->email,
        'cel' => substr($faker->name, 0, 10),
        'tel' => substr($faker->name, 0, 10),
        'localidad' => $faker->address,
        'id_trabajo' => rand(1, 4),
        'id_funcion' => rand(1, 4),
        'id_provincia' => rand(1, 4),
        'id_convenio' => rand(1, 4),
        'establecimiento1' => substr($faker->name, 0, 10),
        'establecimiento2' => substr($faker->name, 0, 10),
        'organismo1' => substr($faker->name, 0, 10),
        'organismo2' => substr($faker->name, 0, 10),
        'id_pais' => rand(1, 20)
    ];
});

/** profesor */
$factory->define(App\Profesor::class, function (Faker\Generator $faker) {
    return [
        'nombres' => substr($faker->name, 0, 10),
        'apellidos' => substr($faker->name, 0, 10),
        'id_tipo_documento' => rand(1, 4),
        'nro_doc' => rand(1, 20000000),
        'email' => $faker->email,
        'cel' => substr($faker->name, 0, 10),
        'tel' => substr($faker->name, 0, 10),
        'id_pais' => rand(1, 20)
    ];
});

/** curso */
$factory->define(App\Models\Cursos\Curso::class, function (Faker\Generator $faker) {

    $id_area_tematica = App\Models\Cursos\AreaTematica::select('id_area_tematica')
    ->pluck('id_area_tematica')
    ->shuffle()
    ->first();

    $id_area_tematica = $id_area_tematica?:factory(App\Models\Cursos\AreaTematica::class, 10)
    ->create()
    ->first()
    ->id_area_tematica;

    $id_linea_estrategica = App\Models\Cursos\LineaEstrategica::select('id_linea_estrategica')
    ->pluck('id_linea_estrategica')
    ->shuffle()
    ->first();

    $id_linea_estrategica = $id_linea_estrategica?:factory(App\Models\Cursos\LineaEstrategica::class, 10)
    ->create()
    ->first()
    ->id_linea_estrategica;

    $id_provincia = App\Provincia::select('id_provincia')
    ->pluck('id_provincia')
    ->shuffle()
    ->first();

    $id_provincia = $id_provincia?:factory(App\Provincia::class, 10)
    ->create()
    ->first()
    ->id_provincia;    

    return [
        'nombre' => substr($faker->name, 0, 10),
        'id_provincia' => $id_provincia,
        'id_area_tematica' => $id_area_tematica,
        'id_linea_estrategica' => $id_linea_estrategica,
    ];
});

/** curso */
$factory->state(App\Models\Cursos\Curso::class, 'completo', function (Faker\Generator $faker) {
    return [
        'fecha' => $faker->date,
        'duracion' => rand(1, 3),
        'edicion' => rand(1, 10)
    ];
});

//Pregunta
$factory->define(App\Models\Encuestas\Pregunta::class, function (Faker\Generator $faker) {
    return [
        'descripcion' => substr($faker->text, 0, 20) . '?'
    ];
});

//Respuesta
$factory->define(App\Models\Encuestas\Respuesta::class, function (Faker\Generator $faker) {
    return [
        'descripcion' => substr($faker->text, 0, 20)
    ];
});

//Encuesta
$factory->define(App\Models\Encuestas\Encuesta::class, function (Faker\Generator $faker) {

    $id_curso = App\Models\Cursos\Curso::select('id_curso')
    ->pluck('id_curso')
    ->shuffle()
    ->first();

    $id_curso = $id_curso?:factory(App\Models\Cursos\Curso::class, 10)
    ->create()
    ->first()
    ->id_curso;

    $id_pregunta = App\Models\Encuestas\Pregunta::select('id_pregunta')
    ->pluck('id_pregunta')
    ->shuffle()
    ->first();

    $id_pregunta = $id_pregunta?:factory(App\Models\Encuestas\Pregunta::class, 10)
    ->create()
    ->first()
    ->id_pregunta;

    $id_respuesta = App\Models\Encuestas\Respuesta::select('id_respuesta')
    ->pluck('id_respuesta')
    ->shuffle()
    ->first();

    $id_respuesta = $id_respuesta?:factory(App\Models\Encuestas\Respuesta::class, 10)
    ->create()
    ->first()
    ->id_respuesta;

    $cantidad = rand(1, 10);

    return compact('id_curso', 'id_pregunta', 'id_respuesta', 'cantidad');
});


/** pac */
$factory->define(App\Models\Pac\Pac::class, function (Faker\Generator $faker) {

    return [
        'trimestre_planificacion' => strval(rand(1, 4)) . 'T',
        't1' => boolval(rand(0, 1))?'X':'',
        't2' => boolval(rand(0, 1))?'X':'',
        't3' => boolval(rand(0, 1))?'X':'',
        't4' => boolval(rand(0, 1))?'X':'',
        'consul_peatyc' => boolval(rand(0, 1)),
        'observado' => ''
    ];
});

