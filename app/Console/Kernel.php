<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\GetFile::class,
        \App\Console\Commands\EntityMakeCommand::class,
        \App\Console\Commands\ViewMakeCommand::class,
        \App\Console\Commands\GetLogCommand::class,        
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function (){
            $path = __DIR__.'/../../storage/exports/*';
            system("rm {$path}");
        })->everyMinute();

        $schedule->call(function (){
            system('date=$(date +%T); file="$date.txt"; echo $file | xargs touch');
        })->everyMinute();
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
