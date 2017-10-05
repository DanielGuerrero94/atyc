<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class ViewMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view
    {name : The name of the view folder}
    {--R|rollback : Delete view folder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD views for model';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model Views';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() 
    {
        return __DIR__.'/stubs/model.stub';
    }

    /**
     * Default files.
     * Deberia agregarle los stub.
     * 
     * @var array
     */
    protected $filenames = ['abm','alta','baja','modificacion','filtros'];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = 'resources/views/'.$this->argument('name');

        if ($this->option('rollback')) {
            system('rm -rf '.$path);
            $this->info('Views folder erased successfully.');
        } else {
            system('mkdir '.$path);

            foreach ($this->filenames as $file) {
                system('touch '.$path.'/'.$file.'.blade.php');
            }
            $this->info('Views folder created successfully.');
        }
    }
}
