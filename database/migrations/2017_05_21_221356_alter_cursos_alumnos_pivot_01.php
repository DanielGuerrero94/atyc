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
            $table->primary(['id_curso', 'id_alumno']);
            $table->foreign('id_curso')->references('id_curso')->on('cursos.cursos');
            $table->foreign('id_alumno')->references('id_alumno')->on('alumnos.alumnos');
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
