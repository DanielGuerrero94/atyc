<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMaterialesTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sistema.materiales', function (Blueprint $table) {
            $table->text('descripcion')->nullable();
            $table->integer('id_etapa')->nullable();
            $table->integer('orden')->nullable();
            $table->unique(['original', 'id_etapa']);
            $table->unique('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sistema.materiales', function (Blueprint $table) {
            $table->dropColumn('descripcion');
            $table->dropColumn('id_etapa');
            $table->dropColumn('orden');
            $table->dropUnique('path');
        });
    }
}
