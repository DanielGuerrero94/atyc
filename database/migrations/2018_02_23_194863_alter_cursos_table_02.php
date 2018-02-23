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
            $table->date('fecha')->nullable(true)->change();
            $table->float('duracion')->nullable(true)->change();
            $table->smallInteger('edicion')->nullable(true)->change();
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
            $table->date('fecha')->nullable(false)->change();
            $table->float('duracion')->nullable(false)->change();
            $table->smallInteger('edicion')->nullable(false)->change();
        });
    }
}
