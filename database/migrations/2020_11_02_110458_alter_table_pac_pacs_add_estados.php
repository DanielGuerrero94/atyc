<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePacPacsAddEstados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pac.pacs', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estado')->nullable();

            $table->foreign('id_estado')->references('id_estado')->on('pac.estados')->onUpdate('NO ACTION')->onDelete('NO ACTION'); 
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
            $table->dropForeign(['id_estado']);
            $table->dropColumn('id_estado');
        });
    }
}
