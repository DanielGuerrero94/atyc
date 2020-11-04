<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePacCambiosEstado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac.cambios_estado', function (Blueprint $table) {
            $table->increments('id');
            $table->text('mensaje')->nullable();
            $table->unsignedBigInteger('id_pac');
            $table->unsignedBigInteger('id_estado_anterior');
            $table->unsignedBigInteger('id_estado_nuevo');
            $table->timestamps();

            $table->foreign('id_pac')->references('id_pac')->on('pac.pacs')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('id_estado_anterior')->references('id_estado')->on('pac.estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('id_estado_nuevo')->references('id_estado')->on('pac.estados')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pac.cambios_estado');
    }
}
