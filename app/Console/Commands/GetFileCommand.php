<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:file 
        {name : Name of the file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets a file with sftp';

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
        $name = $this->argument('name');
        system(
            'sshpass -p \''.env('SSH_PASS').'\' sftp administrador@192.6.0.224 << EOF 
            get /var/www/html/sirge3/storage/uploads/prestaciones/'.$name
        );
    }
}
