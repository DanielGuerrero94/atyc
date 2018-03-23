<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoFichasTecnicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac.estado_fichas_tecnicas', function (Blueprint $table) {
            $table->increments('id_estado_ficha_tecnica');
            $table->string('descripcion', 50);
            $table->string('class', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pac.estado_fichas_tecnicas');
    }
}
