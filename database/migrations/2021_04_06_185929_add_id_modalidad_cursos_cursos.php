<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdModalidadCursosCursos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cursos.cursos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_modalidad')->nullable();

            $table->foreign('id_modalidad')
                ->references('id_modalidad')
                ->on('cursos.modalidades')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
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
            $table->dropForeign(['id_modalidad']);
            $table->dropColumn('id_modalidad');
        });
    }
}
