<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotPacsPautasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac.pacs_pautas', function (Blueprint $table) {
            $table->primary(['id_pac', 'id_pauta']);
            $table->integer('id_pac')->unsigned();
            $table->integer('id_pauta')->unsigned();

            $table->foreign('id_pac')->references('id_pac')->on('pac.pac');
            $table->foreign('id_pauta')->references('id_pauta')->on('pac.pautas');
            
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
        Schema::dropIfExists('pac.pacs_pautas');
    }
}
