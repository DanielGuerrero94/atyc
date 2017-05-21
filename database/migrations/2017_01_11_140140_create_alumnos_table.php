<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos.alumnos', function (Blueprint $table) {
            $table->increments('id_alumno');
            $table->string('nombres');
            $table->string('apellidos');
            $table->integer('id_tipo_documento');
            $table->string('nro_doc');
            $table->string('email')->nullable();
            $table->string('cel')->nullable();
            $table->string('tel')->nullable();
            $table->string('localidad');
            $table->integer('id_trabajo');
            $table->integer('id_funcion');
            $table->integer('id_provincia');
            $table->integer('id_convenio')->nullable();
            $table->string('establecimiento1')->nullable();
            $table->string('establecimiento2')->nullable();
            $table->string('organismo1')->nullable();
            $table->string('organismo2')->nullable();
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
        Schema::dropIfExists('alumnos.alumnos');
    }
}
