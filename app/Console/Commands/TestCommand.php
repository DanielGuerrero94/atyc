<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test
    {name=d : Name of the entity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for testing';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->testMakeModelArguments();
        $this->testAppFacade();
    }

    private function testMakeModelArguments()
    {
        $this->call('make:model', [
            'name' => $this->argument('name'),
            '--migration' => true,
            '--resource' => true,
            '--controller' => true,
        ]);
    }

    private function testAppFacade()
    {
        echo App::basePath();
    }
}
