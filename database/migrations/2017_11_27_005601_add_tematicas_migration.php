<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTematicasMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tematicas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('descripcion');
            $table->timestamps();
        });
        Schema::create('tematica_matriz_pac', function(Blueprint $table){
            $table->integer('id_matriz_pac')->unsigned();
            $table->integer('id_tematica')->unsigned();
            
            $table->foreign('id_matriz_pac')->references('id')->on('matriz_pacs');
            $table->foreign('id_tematica')->references('id')->on('tematicas');
            
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
        Schema::dropIfExists('tematicas');
    }
}
