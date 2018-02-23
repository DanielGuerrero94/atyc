<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProfesoresTable03 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sistema.profesores', function (Blueprint $table) {
            $table->foreign('id_tipo_docente')->references('id_tipo_docente')->on('sistema.tipos_docentes');
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
            $table->dropForeign('sistema_profesores_id_tipo_docente_foreign');
        });
    }
}
