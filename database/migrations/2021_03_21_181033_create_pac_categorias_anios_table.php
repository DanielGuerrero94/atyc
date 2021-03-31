<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacCategoriasAniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac.categorias_anios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('id_categoria');
            $table->integer('anio');
            $table->timestamps();

            $table->foreign('id_categoria')
                ->references('id_categoria')
                ->on('pac.categorias_pautas')
                ->onUpdate('NO ACTION')
                ->OnDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pac.categorias_anios');
    }
}
