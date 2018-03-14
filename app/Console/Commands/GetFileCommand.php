<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class GetFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:file 
        {--p|path : Path of the file}
        {name : Name of the file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets a file with sftp';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->option('path') or '';
        system("sshpass -p '".env('SSH_PASS')."' sftp administrador@192.6.0.224 << EOF get /var/www/html/atyc/{$path}/{$name} EOF");
    }
}
