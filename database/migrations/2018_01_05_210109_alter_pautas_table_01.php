<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPautasTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pac.pautas', function (Blueprint $table) {
            $table->string('vigencia',4);
            $table->integer('id_provincia')->default(25);
            $table->foreign('id_provincia')->references('id_provincia')->on('sistema.provincias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
