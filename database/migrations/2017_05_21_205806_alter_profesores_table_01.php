<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProfesoresTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sistema.profesores', function (Blueprint $table) {
            $table->foreign('id_tipo_documento')->references('id_tipo_documento')->on('sistema.tipos_documentos');
            $table->foreign('id_pais')->references('id_pais')->on('sistema.paises');
            /*$table->foreign('id_tipo_docente')->references('id_tipo_docente')->on('sistema.tipos_docentes');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sistema.profesores', function (Blueprint $table) {            
            $table->dropForeign('sistema_profesores_id_tipo_documento_foreign');
            $table->dropForeign('sistema_profesores_id_pais_foreign');
        });
    }
}
