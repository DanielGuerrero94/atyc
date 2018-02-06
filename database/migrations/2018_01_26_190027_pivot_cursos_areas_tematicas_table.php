<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotCursosAreasTematicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos.cursos_areas_tematicas', function (Blueprint $table) {
            $table->primary(['id_curso', 'id_area_tematica']);
            $table->integer('id_curso')->unsigned();
            $table->integer('id_area_tematica')->unsigned();

            $table->foreign('id_curso')->references('id_curso')->on('cursos.cursos');
            $table->foreign('id_area_tematica')->references('id_area_tematica')->on('cursos.areas_tematicas');
            
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
        Schema::dropIfExists('cursos.cursos_areas_tematicas');
    }
}
