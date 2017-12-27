<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotCursosTalleresSumarteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos.cursos_talleres_sumarte', function(Blueprint $table){
            $table->primary(['id_curso', 'id_taller_sumarte']);
            $table->integer('id_curso')->unsigned();
            $table->integer('id_taller_sumarte')->unsigned();

            $table->foreign('id_curso')->references('id_curso')->on('cursos.cursos');
            $table->foreign('id_taller_sumarte')->references('id_taller_sumarte')->on('pac.talleres_sumarte');
            
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
        Schema::dropIfExists('cursos.cursos_talleres_sumarte');
    }
}