<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPacPacsAddIdPauta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pac.pacs', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pauta')->nullable();
            $table->foreign('id_pauta')
                ->references('id_pauta')
                ->on('pac.pautas')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table->foreign('id_actor')
                ->references('id_actor')
                ->on('pac.actores')
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
        Schema::table('pac.pacs', function (Blueprint $table) {
            $table->dropForeign(['id_actor']);
            $table->dropForeign(['id_pauta']);
            $table->dropColumn('id_actor');
        });
    }
}
