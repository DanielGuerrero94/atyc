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
            $table->integer('anio_vigencia');
            $table->integer('id_accion_pauta')->unsigned();
            
            $table->foreign('id_accion_pauta')->references('id_accion_pauta')->on('pac.acciones_pautas');
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
