<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPacsTable04 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pac.pac', function (Blueprint $table) {
            $table->integer('id_ficha_tecnica')->default(1)->change();
            $table->foreign('id_ficha_tecnica')->references('id_ficha_tecnica')->on('pac.fichas_tecnicas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pac.pac', function (Blueprint $table) {
            $table->integer('id_ficha_tecnica')->nullable()->change();
        });
    }
}
