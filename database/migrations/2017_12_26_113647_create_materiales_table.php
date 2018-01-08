<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema.materiales', function (Blueprint $table) {
            $table->increments('id_material');
            $table->string('path');
            $table->string('original');
            $table->text('descripcion')->nullable();
            $table->integer('id_etapa')->nullable();
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
        Schema::drop('sistema.materiales');
    }
}
