<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCursosAlumnosPivot01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cursos.cursos_alumnos', function (Blueprint $table) {
            $table->primary(['id_cursos', 'id_alumnos']);
            $table->foreign('id_cursos')->references('id_curso')->on('cursos.cursos');
            $table->foreign('id_alumnos')->references('id_alumno')->on('alumnos.alumnos');
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
