<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProvincialInPacCategoriasPautasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pac.categorias_pautas', function (Blueprint $table) {
            $table->boolean('provincial')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pac.categorias_pautas', function (Blueprint $table) {
            $table->dropColumn('provincial');
        });
    }
}
