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
        \DB::statement('CREATE SCHEMA beneficiarios');
        \DB::statement('CREATE SCHEMA efectores');
        \DB::statement('CREATE SCHEMA geo');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP SCHEMA alumnos CASCADE'); 
        \DB::statement('DROP SCHEMA cursos CASCADE');        
        \DB::statement('DROP SCHEMA encuestas CASCADE');
        \DB::statement('DROP SCHEMA pac CASCADE');        
        \DB::statement('DROP SCHEMA sistema CASCADE'); 
        \DB::statement('DROP SCHEMA beneficiarios CASCADE'); 
        \DB::statement('DROP SCHEMA efectores CASCADE'); 
        \DB::statement('DROP SCHEMA geo CASCADE'); 
    }
}
