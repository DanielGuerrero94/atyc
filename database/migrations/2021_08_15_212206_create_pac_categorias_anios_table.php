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
            $table->integer('id_categoria');
            $table->integer('anio');
            $table->primary(['id_categoria', 'anio']);
            $table->timestamps();

            $table->foreign('id_categoria')->references('id_categoria')->on('pac.categorias_pautas');
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
