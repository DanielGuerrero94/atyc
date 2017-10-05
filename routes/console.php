<?php

use Illuminate\Foundation\Inspiring;

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