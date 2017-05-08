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
        Schema::create('cursos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->smallInteger('tipo_doc');//FK
            $table->smallInteger('nro_doc');//unique con tipo_doc
            $table->string('email');
            $table->string('cel');
            $table->string('tel');
            $table->integer('id_provincia');
            $table->integer('id_tipo_trabajo');
            $table->integer('id_funcion');
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
        Schema::dropIfExists('cursos');
    }
}
