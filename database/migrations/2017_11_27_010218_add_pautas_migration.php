<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPautasMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pautas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item', 10);
            $table->string('nombre', 100);
            $table->text('descripcion');
            $table->integer('id_pauta_action')->unsigned();

            $table->foreign('id_pauta_action')->references('id')->on('pautas_actions');
            $table->timestamps();
        });
        Schema::create('pauta_matriz_pac', function(Blueprint $table){
            $table->integer('id_matriz_pac')->unsigned();
            $table->integer('id_pauta')->unsigned();

            $table->foreign('id_matriz_pac')->references('id')->on('matriz_pacs');
            $table->foreign('id_pauta')->references('id')->on('pautas');
            
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
        Schema::dropIfExists('pautas');
    }
}
