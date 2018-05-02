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

if (! function_exists('dependency')) {
    function dependency($class, $id_name, $quantity)
    {
        $id = $class::select($id_name)
        ->pluck($id_name)
        ->shuffle()
        ->first();

        $id = $id?:factory($class, $quantity)
        ->create()
        ->shuffle()
        ->first()
        ->id_name;

        return $id;
    }
}

/** alumno */
$factory->define(App\Alumno::class, function (Faker\Generator $faker) {
    dependency('App\Convenio', 'id_convenio', 4);
    dependency('App\TipoDocumento', 'id_tipo_documento', 4);
    dependency('App\Pais', 'id_pais', 20);
    dependency('App\Funcion', 'id_funcion', 4);
    dependency('App\Trabajo', 'id_trabajo', 4);

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
        'id_convenio' => rand(1, 2),
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

$factory->define(App\TipoDocente::class, function (Faker\Generator $faker) {
    return [
        'nombre' => substr($faker->name, 0, 10),
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

$factory->define(App\Models\Pac\ComponenteCa::class, function (Faker\Generator $faker) {
    return [
        'nombre' => $faker->word,
        'anio_vigencia' => '2018'
    ];
});

$factory->define(App\Models\Pac\CategoriaPauta::class, function (Faker\Generator $faker) {
    return [
        'nombre' => $faker->word,
        'item' => rand(1, 10),
        'descripcion' => $faker->word,
        'anio_vigencia' => '2018'
    ];
});

$factory->define(App\Models\Pac\Pauta::class, function (Faker\Generator $faker) {

    $id_categoria_pauta = App\Models\Pac\CategoriaPauta::pluck('id_categoria_pauta')
    ->shuffle()
    ->first();

    $id_categoria_pauta = $id_categoria_pauta?:factory(App\Models\Pac\CategoriaPauta::class, 12)
    ->create()
    ->first()
    ->id_categoria_pauta;

    $id_provincia = App\Provincia::pluck('id_provincia')
    ->shuffle()
    ->first();

    $id_provincia = $id_provincia?:factory(App\Provincia::class, 10)
    ->create()
    ->first()
    ->id_provincia;

    return [
        'nombre' => $faker->word,
        'item' => rand(1, 10),
        'descripcion' => $faker->word,
        'vigencia' => '2018',
        'id_provincia' => $id_provincia,
        'id_categoria_pauta' => $id_categoria_pauta
    ];
});

$factory->define(App\Models\Pac\Pac::class, function (Faker\Generator $faker) {

    $curso =  factory(App\Models\Cursos\Curso::class)->make();
    $nombre = $curso->nombre;
    $id_provincia = $curso->id_provincia;
    $id_area_tematica = $curso->id_area_tematica;
    $id_linea_estrategica = $curso->id_linea_estrategica;

    $areasTematicas = "$id_area_tematica";

    $destinatarios = App\Funcion::take(rand(1, 3))
        ->pluck('id_funcion')
        ->toArray();

    $destinatarios = $destinatarios?:factory(App\Funcion::class, 12)
    ->create()
    ->take(rand(1, 3))
    ->pluck('id_funcion')
    ->toArray();
    
    $destinatarios = implode(",", $destinatarios);

    $componentesCa = App\Models\Pac\ComponenteCa::take(rand(1, 3))
        ->pluck('id_componente_ca')
        ->toArray();

    $componentesCa = $componentesCa?:factory(App\Models\Pac\ComponenteCa::class, 12)
    ->create()
    ->take(rand(1, 3))
    ->pluck('id_componente_ca')
    ->toArray();
    
    $componentesCa = implode(",", $componentesCa);
    
    $pautas = App\Models\Pac\Pauta::take(rand(1, 3))
        ->pluck('id_pauta')
        ->toArray();

    $pautas = $pautas?:factory(App\Models\Pac\Pauta::class, 12)
    ->create()
    ->take(rand(1, 3))
    ->pluck('id_pauta')
    ->toArray();
    
    $pautas = implode(",", $pautas);

    $parametros_pac = [
        'trimestre_planificacion' => strval(rand(1, 4)) . 'T',
        't1' => boolval(rand(0, 1)),
        't2' => boolval(rand(0, 1)),
        't3' => boolval(rand(0, 1)),
        't4' => boolval(rand(0, 1)),
        'consul_peatyc' => boolval(rand(0, 1)),
        'repeticiones' => rand(1, 10),
        'observado' => $faker->text
    ];

    $relaciones_pac = compact('destinatarios', 'componentesCa', 'pautas');

    $parametros_pac = array_merge($relaciones_pac, $parametros_pac);

    $parametros_acciones = compact('nombre', 'id_provincia', 'areasTematicas', 'id_linea_estrategica');

    return array_merge($parametros_pac, $parametros_acciones);
});


$factory->define(App\Models\Pac\FichaTecnica::class, function (Faker\Generator $faker) {
    return [
        'path' => $faker->word,
        'original' => $faker->word,
        'comentarios' => $faker->text
    ];
});
