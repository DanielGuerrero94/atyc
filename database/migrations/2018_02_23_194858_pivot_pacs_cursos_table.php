<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotPacsCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac.pacs_cursos', function (Blueprint $table) {
            $table->primary(['id_pac', 'id_curso']);
            $table->integer('id_pac')->unsigned();
            $table->integer('id_curso')->unsigned();

            $table->foreign('id_pac')->references('id_pac')->on('pac.pac');
            $table->foreign('id_curso')->references('id_curso')->on('cursos.cursos');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pac.pacs_cursos');
    }
}
