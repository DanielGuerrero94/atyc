<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ControllerTestMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:test-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller test';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/test-controller.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace($this->laravel->getNamespace(), '', $name);

        return $this->laravel['path.base'].'/tests/controllers/'.str_replace('\\', '/', $name).'ControllerTest.php';
    }
}
