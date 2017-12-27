<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccionesPautasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac.acciones_pautas', function (Blueprint $table) {
            $table->increments('id_accion_pauta');
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
        Schema::dropIfExists('pac.acciones_pautas');
    }
}
