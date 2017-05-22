<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotCursosAlumnos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos.cursos_alumnos', function (Blueprint $table) {
            $table->integer('id_cursos');//FK
            $table->integer('id_alumnos');//FK
            $table->timestamps();            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos.cursos_alumnos');
    }
}
