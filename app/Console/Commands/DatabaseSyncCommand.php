<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class DatabaseSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sync {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync tables from production';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->table = $this->argument('table');

        $this->truncate();

        $this->getBackup();

        $this->restore();
    }

    public function truncate() {
        $status = DB::statement("TRUNCATE TABLE " . $this->table);
        $this->info($this->table . " was truncated.");
    }

    public function getBackup() {
        $this->call('db:backup', ['--table' => $this->table]);
        $this->info($this->table . " was backed up.");
    }

    public function restore() {
        $this->call('db:restore', ['--table' => $this->table]);
        $this->info($this->table . " was restored.");
    }

}
