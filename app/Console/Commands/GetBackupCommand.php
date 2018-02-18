<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class GetBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un .sql para replicar inserts';

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
        $tables = $this->allTables();
        foreach ($tables as $table) {
            system("pg_dump -U postgres atyc -h 192.6.0.66 -t {$table} --data-only --inserts > database/backups/{$table}.sql");
        }
    }

    public function allTables()
    {
        $tables = [];
        //Consigue los archivos en migrations que usen create table
        $files = (new Finder())->files()->in(database_path('/migrations'))->name('/create/');
        foreach ($files as $file) {
            $path = $file->getRealPath();
            $content = file_get_contents($path);
            //Del contenido que consiguio del archivo solo busca el nombre de la tabla tenga o no schema
            preg_match_all('/Schema::create\(\'(\w+(?:\.\w+)?)\'/', $content, $table);
            $tables[] = $table[1][0];
        }
        return $tables;
    }
}
