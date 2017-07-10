<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EntityMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:entity 
        {name : Name of the entity}
        {plural=s : Plural}
        {--c|complete : Create with model,controller,migration,seeder,faker,test,etc...}
        {--R|rollback : Remove all files created for the entity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new entity class';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        if ($this->option('complete')) {            
            system('php artisan make:view '.$name.$this->argument('plural'));
            $name = ucfirst($name);
            system('php artisan make:model -mcr '.$name);
            system('php artisan make:test '.$name.'Test');
            system('php artisan make:seeder '.$name.'Seeder');
            $this->info('Entity created successfully.');
        } elseif ($this->option('rollback')) {
            system('php artisan make:view -R '.$name.$this->argument('plural'));
            system('cd database/migrations/ && ls | grep '
                .$name
                .$this->argument('plural')
                .' | xargs rm');
            $name = ucfirst($name);
            system('rm app/'.$name.'.php');
            system('rm app/Http/Controllers/'.$name.'Controller.php');
            system('rm database/seeds/'.$name.'Seeder.php');
            system('rm tests/'.$name.'Test.php');
            $this->info('Entity erased successfully.');
        }       
    }
}
