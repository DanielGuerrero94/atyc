<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasPautasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac.categorias_pautas', function (Blueprint $table) {
            $table->increments('id_categoria_pauta');
            $table->integer('item');
            $table->string('nombre');
            $table->text('descripcion');
            $table->integer('anio_vigencia');
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
        Schema::dropIfExists('pac.categorias_pautas');
    }
}
