<?php
/**
 * Command to make posible to get the log file parsed
 *
 * @package Commands
 * @author Daniel Guerrero 
 **/

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:log
    {day=today : Day of the log file}
    {--m|model=all : Search request for a model}
    {--c|complete : Create json files with the CRUD request in the log file}
    {--D|delete : Remove all files created for the log files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get log file from production';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $day = $this->argument('day') === 'today'?date("Y-m-d"):$this->argument('day');
        $model = $this->option('model');

        $folder = env('APP_PATH').'storage/logs/production';
        $log_file_name = "laravel-{$day}.log";

        if ($this->option('delete')) {
            system("rm -f {$folder}/*");
        }

        if (!file_exists("{$folder}/{$log_file_name}")) {
            system(
                "sshpass -p '".env('SSH_PASS')."' sftp ".env('SSH_USER_PROD')."@".env('SSH_IP_PROD')." << EOF 
                get ".env('APP_PATH')."storage/logs/{$log_file_name}"
            );
            system(
                "mv {$log_file_name} {$folder}"
            );
        }

        if ($this->option('complete')) {
            if ($this->option('model') === 'all') {
                system(
                    "grep 'crear' {$folder}/{$log_file_name} > {$folder}/create-{$day}.log"
                );
                system(
                    "grep 'actualizar' {$folder}/{$log_file_name} > {$folder}/update-{$day}.log"
                );
                system(
                    "grep 'baja' {$folder}/{$log_file_name} > {$folder}/delete-{$day}.log"
                );

                $this->info('CRUD json file created');
            } else {
                system(
                    "grep -P 'crear\ {$model}' {$folder}/{$log_file_name} | "."sed 's/^.*crear\ {$model}.*:\ //g' > {$folder}/create-{$model}-{$day}.log"
                );
                system(
                    "grep -P 'actualizar\ {$model}' {$folder}/{$log_file_name} | ".
                    "sed 's/^.*actualizar\ {$model}.*:\ //g' > {$folder}/update-{$model}-{$day}.log"
                );
                system(
                    "grep -P 'baja\ {$model}' {$folder}/{$log_file_name} | ".
                    "sed 's/^.*baja\ {$model}.*:\ //g' > {$folder}/delete-{$model}-{$day}.log"
                );

                $this->info("CRUD json file created for {$model}");
            }
        }
    }
}
