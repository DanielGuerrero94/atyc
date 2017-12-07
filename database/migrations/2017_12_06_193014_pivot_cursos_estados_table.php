<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotCursosEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos.cursos_estados', function(Blueprint $table){
            $table->integer('id_curso')->unsigned();
            $table->integer('id_estado')->unsigned();

            $table->foreign('id_curso')->references('id_curso')->on('cursos.cursos');
            $table->foreign('id_estado')->references('id_estado')->on('pac.estados');
            
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
        Schema::dropIfExists('cursos.cursos_estados');
    }
}
