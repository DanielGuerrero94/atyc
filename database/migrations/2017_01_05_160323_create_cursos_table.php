<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos.cursos', function (Blueprint $table) {
            $table->increments('id_curso');
            $table->string('nombre');
            $table->integer('id_provincia');//FK
            $table->integer('id_area_tematica');//FK
            $table->integer('id_linea_estrategica');//FK
            $table->date('fecha');
            $table->float('duracion');
            $table->smallInteger('edicion');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos.cursos');
    }
}
