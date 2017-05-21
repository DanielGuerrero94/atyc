<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfesoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema.profesores', function (Blueprint $table) {
            $table->increments('id_profesor');
            $table->string('nombres');
            $table->string('apellidos');
            $table->integer('id_tipo_documento');
            $table->string('nro_doc');
            $table->string('email')->nullable();
            $table->string('cel')->nullable();
            $table->string('tel')->nullable();
            $table->integer('id_pais')->nullable();
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
        Schema::dropIfExists('sistema.profesores');
    }
}
