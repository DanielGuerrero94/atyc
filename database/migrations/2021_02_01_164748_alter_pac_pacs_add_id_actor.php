<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPacPacsAddIdActor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pac.pacs', function(Blueprint $table) {
            $table->unsignedBigInteger('id_actor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pac.pacs', function(Blueprint $table) {
            $table->dropColumn('id_actor');
        });
    }
}
