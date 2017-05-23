<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCursosTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cursos.cursos', function (Blueprint $table) {
            $table->foreign('id_provincia')->references('id_provincia')->on('sistema.provincias');
            $table->foreign('id_area_tematica')->references('id_area_tematica')->on('cursos.areas_tematicas');
            $table->foreign('id_linea_estrategica')->references('id_linea_estrategica')->on('cursos.lineas_estrategicas');
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
           $table->dropForeign('cursos_cursos_id_provincia_foreign');
            $table->dropForeign('cursos_cursos_id_area_tematica_foreign');
            $table->dropForeign('cursos_cursos_id_linea_estrategica_foreign');
        });
    }
}
