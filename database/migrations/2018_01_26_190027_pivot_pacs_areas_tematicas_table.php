<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotPacsAreasTematicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac.pacs_areas_tematicas', function (Blueprint $table) {
            $table->primary(['id_pac', 'id_area_tematica']);
            $table->integer('id_pac')->unsigned();
            $table->integer('id_area_tematica')->unsigned();

            $table->foreign('id_pac')->references('id_pac')->on('pac.pac');
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
        Schema::dropIfExists('pac.pacs_areas_tematicas');
    }
}
