<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAlumnosTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos.alumnos', function (Blueprint $table) {
            $table->foreign('id_tipo_documento')->references('id_tipo_documento')->on('sistema.tipos_documentos');
            $table->foreign('id_provincia')->references('id_provincia')->on('sistema.provincias');
            $table->foreign('id_pais')->references('id_pais')->on('sistema.paises');
            $table->foreign('id_trabajo')->references('id_trabajo')->on('alumnos.trabajos');
            $table->foreign('id_funcion')->references('id_funcion')->on('alumnos.funciones');
            $table->foreign('id_convenio')->references('id_convenio')->on('alumnos.convenios');
            $table->foreign('id_genero')->references('id_genero')->on('alumnos.generos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos.alumnos', function (Blueprint $table) {
            $table->dropForeign('alumnos_alumnos_id_tipo_documento_foreign');
            $table->dropForeign('alumnos_alumnos_id_provincia_foreign');
            $table->dropForeign('alumnos_alumnos_id_pais_foreign');
            $table->dropForeign('alumnos_alumnos_id_trabajo_foreign');
            $table->dropForeign('alumnos_alumnos_id_funcion_foreign');
            $table->dropForeign('alumnos_alumnos_id_convenio_foreign');
            $table->dropForeign('alumnos_alumnos_id_genero_foreign');
        });
    }
}
