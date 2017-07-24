<?php

use Illuminate\Database\Seeder;

class ForeignDataWrapperSeeder extends Seeder 
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = env('SERVER_NAME');
        $host = env('SERVER_HOST');
        $dbname = env('SERVER_DBNAME');
        $port = env('SERVER_PORT');
        $user = env('SERVER_USER');
        $password = env('SERVER_PASSWORD');

        if($host && $dbname && $port){
            \DB::statement("
        CREATE SERVER {$name} 
        FOREIGN DATA WRAPPER postgres_fdw 
        OPTIONS (host '{$host}', dbname '{$dbname}', port '{$port}')
        ;");
        }else{
            echo 'No se pudo crear el server';
        }

        if($user && $password){
            \DB::statement("
        CREATE USER MAPPING FOR daniel 
        SERVER {$name} 
        OPTIONS (user '{$user}', password '{$password}')
        ;");
        }else{
            echo 'No se pudo crear el mapping para el usuario';
        }              
    }
}
