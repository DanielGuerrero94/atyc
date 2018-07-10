<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterComponentesCaTableAddItemColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pac.componentes_ca', function (Blueprint $table) {
            $table->integer("item")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pac.componentes_ca', function (Blueprint $table) {
            $table->dropColumn("item");
        });
    }
}
