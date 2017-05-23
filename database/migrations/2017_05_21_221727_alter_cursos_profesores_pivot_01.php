<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCursosProfesoresPivot01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cursos.cursos_profesores', function (Blueprint $table) {
            $table->primary(['id_cursos', 'id_profesores']);
            $table->foreign('id_cursos')->references('id_curso')->on('cursos.cursos');
            $table->foreign('id_profesores')->references('id_profesor')->on('sistema.profesores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
