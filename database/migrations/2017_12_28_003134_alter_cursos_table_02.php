<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCursosTable02 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cursos.cursos', function (Blueprint $table) {
            $table->integer('id_estado')->default(1);
            $table->foreign('id_estado')
            ->references('id_estado')->on('cursos.estados');
        });

        \DB::statement("UPDATE cursos.cursos set id_estado = 3;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cursos.cursos', function (Blueprint $table) {
            $table->dropForeign('cursos_cursos_id_estado_foreign');
        });
    }
}
