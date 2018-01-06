<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class DatabaseRestoreCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Restore command
     *
     * @var string
     */
    protected $restoreCommand;

    /**
     * Paths to backup files
     *
     * @var string
     */
    protected $restorePaths;

    /**
     * Table of succeed restore
     *
     * @var string
     */
    protected $table = [];

    /**
     * Table of failed restore
     *
     * @var string
     */
    protected $errors = [];

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
        $this->call('migrate:refresh');
        $this->getBackupPaths()->setRestoreConnection();
        $this->restore();
        $this->info("Restored");
        $this->table(['table', 'step'], $this->formatOutput($this->table));
        $this->error("Failed");
    }

    public function restore()
    {
        for ($step=0; !empty($this->restorePaths) && $step < 10; $step++) { 
            foreach ($this->restorePaths as $path) {
                system($this->restoreCommand." -f {$path} -1 -q 1> /dev/null 2> /tmp/result.log");
                $output = file_get_contents('/tmp/result.log');
                if (!preg_match('/ERROR/', $output)) {
                    $table = $this->storeSucceedTable($path, $step);
                    unset($this->restorePaths[$table]);
                } else {
                    $table = $this->tableName($path);
                    $this->error[$step][] = $table;
                }
            }
            
        }
    }

    public function getBackupPaths()
    {
        $files = (new Finder())->files()->in(database_path('/backups'));

        $paths = [];

        foreach ($files as $file) {
            $path = $file->getRealPath();
            $name = $this->tableName($path);
            $paths[$name] = $path;
        }   
        
        $this->restorePaths = $paths;
        return $this;
    }

    public function setRestoreConnection()
    {
        $db_password = env('DB_PASSWORD');
        $db_username = env('DB_USERNAME');
        $db_database = env('DB_DATABASE');
        $this->restoreCommand = "PGPASSWORD='{$db_password}' psql -U {$db_username} -d {$db_database} ";
        return $this;
    }

    public function tableName($path)
    {
        $name = [];
        preg_match_all('/\/(\w+(?:\.\w+)?)\.sql$/', $path, $name);
        return $name[1][0];
    }


    public function storeSucceedTable($path, $step)
    {
        $name = $this->tableName($path);
        $this->table[$step][] = $name;
        return $name;
    }

    public function formatOutput($array)
    {
        $output = [];
        for ($i=0; $i < count($array); $i++) { 
            for ($j=0; $j < count($array[$i]); $j++) { 
                $output[] = [$array[$i][$j], $i];
            }
        }
        return $output;
    }
}