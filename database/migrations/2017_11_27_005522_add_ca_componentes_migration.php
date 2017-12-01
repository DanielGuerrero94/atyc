<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCaComponentesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ca_componentes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('anio_vigencia');
            $table->timestamps();
        });
        Schema::create('ca_componente_matriz_pac', function(Blueprint $table){
            $table->integer('id_matriz_pac')->unsigned();
            $table->integer('id_ca_componente')->unsigned();

            $table->foreign('id_matriz_pac')->references('id')->on('matriz_pacs');
            $table->foreign('id_ca_componente')->references('id')->on('ca_componentes');
            
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
        Schema::dropIfExists('ca_componentes');
    }
}
