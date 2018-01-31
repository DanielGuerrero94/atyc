<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCursosTable04 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cursos.cursos', function (Blueprint $table) {
            $table->dropColumn('id_area_tematica');
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
            $table->integer('id_area_tematica');
            $table->foreign('id_area_tematica')->references('id_area_tematica')->on('cursos.areas_tematicas');
        });
    }
}
