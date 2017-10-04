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
        $plural = $this->argument('plural');

        if ($this->option('complete')) {

            $this->complete();

        } elseif ($this->option('rollback')) {

            $this->rollback();

        }       
    }

    protected function complete()
    {
        $name = $this->argument('name');
        $plural = $this->argument('plural');

        $this->call('make:view', [
            'name' => $name.$plural,
        ]);            

        $name = ucfirst($name);

        $this->call('make:model', [
            'name' => $name,
            '--migration' => true,
            '--controller' => true,
            '--resource' => true,
        ]);

        $this->call('make:test', [
            'name' => $name.'Test',
        ]);

        $this->call('make:seeder', [
            'name' => $name.'Seeder',
        ]);

        $this->info('Entity created successfully.');
    }

    protected function rollback()
    {
        $name = $this->argument('name');
        $plural = $this->argument('plural');

        $this->call('make:view', [
            'name' => $name.$plural,
            '--rollback' => true,
        ]);

        system(
            "ls database/migrations/ | ".
            "grep {$name}{$plural} | xargs rm"
        );

        $this->info('Migration erased successfully.');

        $name = ucfirst($name);

        system(
            "rm app/{$name}.php ".
            "app/Http/Controllers/{$name}Controller.php ".
            "database/seeds/{$name}Seeder.php ".
            "tests/{$name}Test.php"
        );

        $this->info('Entity erased successfully.');
    }
}
