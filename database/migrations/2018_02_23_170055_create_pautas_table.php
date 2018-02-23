<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePautasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac.pautas', function (Blueprint $table) {
            $table->increments('id_pauta');
            $table->string('item', 10);
            $table->string('nombre', 100);
            $table->text('descripcion');
            $table->integer('id_categoria_pauta')->unsigned();

            $table->foreign('id_categoria_pauta')->references('id_categoria_pauta')->on('pac.categorias_pautas');
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
        Schema::dropIfExists('pac.pautas');
    }
}
