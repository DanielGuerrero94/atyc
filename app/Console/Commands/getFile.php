<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class getFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getFile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consigue un archivo por sftp';

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
        Sub
        system('sshpass -p \''.env('SSH_PASS').'\' sftp administrador@192.6.0.224 << EOF 
            get /var/www/html/sirge3/storage/uploads/prestaciones/59382d6275518.txt');
    }
}
