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
    protected $signature = 'db:matviews';

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
        $matviews = DB::select("select * from pg_matviews;");        
        /*
         * Deberia tener aca una estructura que me permita saber cuando fue la ultima vez que se actualizo una matview
         * Voy a mostrar una tabla con todos los nombres de las vistas materializadas y cada cuanto tiene planificado si es que tiene en el scheduler refreshearse
         */

        $this->showTableStatus($matviews);
    }

    public function showTableStatus($matviews) {
        
        $matviews = $this->format($matviews);

        $this->table(['fullname', 'count', 'schedule', 'last_refresh'], $matviews);
    }

    public function format($matviews) {
        return collect($matviews)->map(function ($matview) {
            $matview_fullname = $matview->schemaname . "." . $matview->matviewname;
            $count = $this->count($matview_fullname);
            $schedule = 'none';
            $last_refresh = 'never';
            return compact('matview_fullname', 'count', 'schedule', 'last_refresh');
        })->toArray();
    }

    public function count($matview_fullname) {
        return DB::table($matview_fullname)->count();
    }
}
