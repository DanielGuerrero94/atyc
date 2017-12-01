<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDestinatariosMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinatarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->text('descripcion');
            $table->timestamps();
        });
        Schema::create('matriz_pac_destinatario', function(Blueprint $table){
            $table->integer('id_matriz_pac')->unsigned();
            $table->integer('id_destinatario')->unsigned();

            $table->foreign('id_matriz_pac')->references('id')->on('matriz_pacs');
            $table->foreign('id_destinatario')->references('id')->on('destinatarios');

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
        Schema::dropIfExists('destinatarios');
    }
}
