<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ViewMakeCommand extends Command
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
    protected $description = 'Create a new view folder';

    /**
     * Default files.
     * Deberia agregarle los stub.
     * 
     * @var array
     */
    private $files = ['abm','alta','baja','modificacion','filtros'];

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
        $files = ['abm','alta','baja','modificacion','filtros'];
        $base_path = 'resources/views/';
        $path = $base_path.$this->argument('name');

        if ($this->option('rollback')) {
            system('rm -rf '.$path);
            $this->info('Views folder erased successfully.');
        } else {
            system('mkdir '.$path);

            foreach ($files as $file) {
                system('touch '.$path.'/'.$file.'.blade.php');
            }
            $this->info('Views folder created successfully.');
        }
    }
}
