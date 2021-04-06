<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursosLineasEstrategicasModalidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos.lineas_estrategicas_modalidades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('id_linea_estrategica');
            $table->unsignedBigInteger('id_modalidad');

            $table->timestamps();

            $table->unique(['id_linea_estrategica', 'id_modalidad']);

            $table->foreign('id_linea_estrategica')
                ->references('id_linea_estrategica')
                ->on('cursos.lineas_estrategicas')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table->foreign('id_modalidad')
                ->references('id_modalidad')
                ->on('cursos.modalidades')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos.lineas_estrategicas_modalidades');
    }
}
