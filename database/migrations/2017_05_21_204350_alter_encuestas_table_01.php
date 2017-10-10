<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEncuestasTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('encuestas.encuestas', function (Blueprint $table) {
            $table->index('id_curso');
            $table->foreign('id_curso')->references('id_curso')->on('cursos.cursos');
            $table->foreign('id_pregunta')->references('id_pregunta')->on('encuestas.preguntas');
            $table->foreign('id_respuesta')->references('id_respuesta')->on('encuestas.respuestas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('encuestas.encuestas', function (Blueprint $table) {
            //$table->dropIndex('encuestas_encuestas_id_curso_index');
            $table->dropForeign('encuestas_encuestas_id_curso_foreign');
            $table->dropForeign('encuestas_encuestas_id_pregunta_foreign');
            $table->dropForeign('encuestas_encuestas_id_respuesta_foreign');
        });
    }
}
