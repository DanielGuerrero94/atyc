<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class DatabaseMaterializedViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:matviews
    {--i|interactive : Run interactively}
    {--d|describe= : Describe a matview}
    {--r|refresh-all : Refresh all matviews}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manipulates materialized views (Postgresql)';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->identifyMatviews();

        $this->handleOptions();
    
        $this->showTableStatus();
    }

    public function handleOptions() {

        if ($this->option('interactive')) {

            $option = $this->choice("Pick one: ", ['describe', 'refresh']);
            $this->info("Materialized views: " . json_encode($this->matviews));

            if ($option == 'refresh') {
            $matview = $this->anticipate('Refresh matview: ', $this->matviews); 
            $this->info($matview);
            }

            if ($option == 'describe') {
                $matview = $this->anticipate('Describe matview: ', $this->matviews); 
                $this->describe($matview);

                //$this->call('db:matviews', ['--describe']);
            }

            exit;
        }

        if ($matview = $this->option('describe')) {
            $this->describe($matview);
        }
    }

    public function identifyMatviews() {
        $this->matviews = collect(DB::select("select * from pg_matviews;"))
            ->map(function ($matview) {
                return $matview->schemaname . "." . $matview->matviewname;
            })->toArray();
    }

    public function showTableStatus() {
        
        $matviews = $this->format();

        $this->table(['fullname', 'count', 'schedule', 'last_refresh'], $matviews);
    }

    public function format() {
        return collect($this->matviews)->map(function ($matview) {
            $count = $this->count($matview);
            $schedule = 'none';
            $last_refresh = 'never';
            return compact('matview', 'count', 'schedule', 'last_refresh');
        })->toArray();
    }

    public function count($matview) {
        return DB::table($matview)->count();
    }

    public function describe($matview) {
    
            if (!in_array($matview, $this->matviews)) {
                $this->error($matview . " does not exists.");
                exit;
            }

            list($schemaname, $matviewname) = explode('.',$matview);

            $query = "select definition from pg_matviews where schemaname = '{$schemaname}' and matviewname = '{$matviewname}';";

            $definition = DB::select($query);
            $definition = $definition[0]->definition;

            $this->info("Definition for {$matview}: {$definition}");
            exit;
    }
}
