<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Schemas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        \DB::statement('CREATE SCHEMA alumnos'); 
        \DB::statement('CREATE SCHEMA cursos');        
        \DB::statement('CREATE SCHEMA encuestas');
        \DB::statement('CREATE SCHEMA pac');        
        \DB::statement('CREATE SCHEMA sistema');        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP SCHEMA alumnos'); 
        \DB::statement('DROP SCHEMA cursos');        
        \DB::statement('DROP SCHEMA encuestas');
        \DB::statement('DROP SCHEMA pac');        
        \DB::statement('DROP SCHEMA sistema'); 
    }
}
