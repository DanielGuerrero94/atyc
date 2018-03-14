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

