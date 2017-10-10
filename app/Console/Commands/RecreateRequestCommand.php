<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RecreateRequestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recreate:request
    {day=today : Day of the log file}
    {model=all : Search request for a model}
    {--c|complete : Create json files with the CRUD request in the log file}
    {--D|delete : Remove all files created for the log files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $f = fopen(env('APP_PATH').'storage/logs/production/create-participante-2017-09-08.log', 'r');
        $json_request = json_decode(fgets($f), 1);
        $c = new \App\Http\Controllers\AlumnosController();
        $requests = [];
        while ($json_request) {
            $r = new \Illuminate\Http\Request($json_request);
            array_push($requests, $r);
            $json_request = json_decode(fgets($f), 1);
        }

        foreach ($requests as $request) {
            $this->info($c->store($request));
        }
    }
}
