<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotPacsDestinatariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac.pacs_destinatarios', function (Blueprint $table) {
            $table->primary(['id_pac', 'id_funcion']);
            $table->integer('id_pac')->unsigned();
            $table->integer('id_funcion')->unsigned();

            $table->foreign('id_pac')->references('id_pac')->on('pac.pac');
            $table->foreign('id_funcion')->references('id_funcion')->on('alumnos.funciones');
            
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
        Schema::dropIfExists('pac.pacs_destinatarios');
    }
}
