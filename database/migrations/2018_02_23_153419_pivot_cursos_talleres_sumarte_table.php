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
        Schema::create('cursos.talleres_sumarte_destinatarios', function(Blueprint $table){
            $table->primary(['id_taller_sumarte', 'id_destinatario']);
            $table->integer('id_destinatario')->unsigned();
            $table->integer('id_taller_sumarte')->unsigned();

            $table->foreign('id_destinatario')->references('id_funcion')->on('alumnos.funciones');
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
        Schema::dropIfExists('cursos.talleres_sumarte_destinatarios');
    }
}