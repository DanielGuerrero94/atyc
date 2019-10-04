<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\ControllerTestMakeCommand::class,
        \App\Console\Commands\EntityMakeCommand::class,
        \App\Console\Commands\DatabaseRestoreCommand::class,
        \App\Console\Commands\GetBackupCommand::class,
        \App\Console\Commands\GetFileCommand::class,
        \App\Console\Commands\GetLogCommand::class,
        \App\Console\Commands\ViewMakeCommand::class,
        \App\Console\Commands\RecreateRequestCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
//            $runned = DB::statement("REFRESH MATERIALIZED VIEW efectores.mv_efectores_conveniados");
        })->dailyAt('07:00');
        
        $schedule->call(function () {
  //          $runned = DB::statement("refresh materialized view efectores.mv_reporte_4");
        })->dailyat('07:02');

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        include base_path('routes/console.php');
    }
}
