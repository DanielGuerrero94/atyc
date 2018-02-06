<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCursosTable03 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('cursos.cursos', function (Blueprint $table) {
            $table->integer('id_estado')->nullable();
        });

        //Antes de levantar la foreign key voy a tener que hacer un update de todos los cursos
        \DB::statement("UPDATE cursos.cursos set id_estado = 3;");

        Schema::table('cursos.cursos', function (Blueprint $table) {
            $table->foreign('id_estado')->references('id_estado')->on('cursos.estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cursos.cursos', function (Blueprint $table) {
            $table->dropColumn('id_estado');
        });
    }
}
