<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use App\Http\Controllers\AlumnosController;
use App\Alumno;
use App\Material;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('test:make-model {name}', function () {
    $this->call('make:model', [
        'name' => $this->argument('name'),
        '--migration' => true,
        '--resource' => true,
        '--controller' => true,
    ]);
})->describe('Command for testing.');

Artisan::command('test:apellidosTypea {typeahead}', function () {
    $c = new AlumnosController();
    $r = new Request(['q' => $this->argument('typeahead')]);
    $this->comment(json_encode($r->all()));
    Auth::attempt(['name' => 'uec', 'password' => 'uec001']);
    $this->info($c->getApellidos($r));
})->describe('Command for testing.');

Artisan::command('test:show {id_participante}', function () {
    Auth::attempt(['name' => 'uec', 'password' => 'uec001']);

    $c = new AlumnosController();
    
    $participante = $c->show($this->argument('id_participante'));

    $this->comment(json_encode($participante));
})->describe('Command for testing.');

Artisan::command('test:get-materiales', function (Material $material) {
    $materiales = $material::select('path')->get();

    foreach ($materiales as $material) {
        $this->info($material->path);
        $this->call('get:file', [
            'name' => $material->path,
            '--path' => "app/material"
        ]);
    }
})->describe('Get Materiales files from production');

Artisan::command('recover:ppac', function () {
    $json = '{"_token":"TgAPbeclOZU5z3xVYHnzprVbYH2CTnGnfgjX5SKb","id_linea_estrategica":"8","nombre":"Capacitacion Integral Programa CUS SUMAR","repeticiones":"2","t1":true,"t2":true,"t4":true,"observado":"La tem\u00e1tica se centrar\u00e1 en una visi\u00f3n integral del Programa SUMAR: primera aproximaci\u00f3n a sus objetivos, circuitos y procesos.","pautas":"13","destinatarios":"1","areasTematicas":"17","componentesCa":"51","t3":false,"id_estado":1,"id_provincia":6}';

$segundo = '{"_token":"TgAPbeclOZU5z3xVYHnzprVbYH2CTnGnfgjX5SKb","id_linea_estrategica":"8","nombre":"JORNADAS DE TRABAJO INTERNO. PROGRAMA SUMAR.","repeticiones":"2","t1":true,"t2":true,"t3":true,"t4":true,"observado":"","pautas":"14","destinatarios":"1","areasTematicas":"6","componentesCa":"51","id_estado":1,"id_provincia":6}';

$tercero = '{"_token":"TgAPbeclOZU5z3xVYHnzprVbYH2CTnGnfgjX5SKb","id_linea_estrategica":"8","nombre":"Capacitacion Integral Programa CUS SUMAR","repeticiones":"2","t1":true,"t2":true,"t4":true,"observado":"La tem\u00e1tica se centrar\u00e1 en una visi\u00f3n integral del Programa SUMAR: primera aproximaci\u00f3n a sus objetivos, circuitos y procesos.","pautas":"13","destinatarios":"1","areasTematicas":"17","componentesCa":"51","t3":false,"id_estado":1,"id_provincia":6}';

    $request = new Request(json_decode($tercero, true));
    $this->info(json_encode($request));
    $controller = app()->make(App\Http\Controllers\PacsController::class);
    $response = $controller->store($request);
    dd($response);
})->describe('Recover ppac');



