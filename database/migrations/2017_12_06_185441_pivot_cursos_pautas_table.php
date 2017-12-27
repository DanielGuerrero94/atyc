<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotCursosPautasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos.cursos_pautas', function(Blueprint $table){
            $table->integer('id_curso')->unsigned();
            $table->integer('id_pauta')->unsigned();

            $table->foreign('id_curso')->references('id_curso')->on('cursos.cursos');
            $table->foreign('id_pauta')->references('id_pauta')->on('pac.pautas');
            
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
        Schema::dropIfExists('cursos.cursos_pautas');
    }
}
