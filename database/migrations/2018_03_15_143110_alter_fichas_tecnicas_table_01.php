<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFichasTecnicasTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pac.fichas_tecnicas', function (Blueprint $table) {
            $table->boolean('aprobada')->default('false');
            $table->text('comentarios')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pac.fichas_tecnicas', function (Blueprint $table) {
            $table->dropColumn('aprobada');
            $table->dropColumn('comentarios');
        });
    }
}
