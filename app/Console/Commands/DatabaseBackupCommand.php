<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class DatabaseBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--t|table=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un .sql para replicar inserts';

    /**
     * Execute the console command.
     *
     * Uses pg_dump on unix-like systems
     *
     * @return mixed
     */
    public function handle()
    {
        $this->chooseTables();

        $this->saveBackupFiles();
    }

    public function getAllTablesNames()
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

    public function chooseTables()
    {
        if ($table = $this->option('table')) {
            $this->tables[] = $table;
        } else {
            $this->tables = $this->getAllTablesNames();
        }
    }

    public function setTablePathName($table)
    {
        return database_path("backups/{$table}.sql");
    }

    public function saveBackupFiles()
    {
        foreach ($this->tables as $table) {
            system("pg_dump -U postgres atyc -h 192.6.0.66 -t {$table} --data-only --inserts > ". $this->setTablePathName($table));
        }
    }
}
