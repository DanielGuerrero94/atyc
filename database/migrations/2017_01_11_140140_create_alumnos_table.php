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
            $table->integer('id_tipo_documento');//FK
            $table->string('nro_doc');
            $table->integer('id_genero');//FK
            $table->string('email')->nullable();
            $table->string('cel')->nullable();
            $table->string('tel')->nullable();
            $table->string('localidad');
            $table->integer('id_trabajo');//FK
            $table->integer('id_funcion');//FK
            $table->integer('id_provincia');//FK
            $table->integer('id_convenio')->nullable();//FK
            $table->string('establecimiento1')->nullable();
            $table->string('establecimiento2')->nullable();
            $table->string('organismo1')->nullable();
            $table->string('organismo2')->nullable();
            $table->integer('id_pais')->nullable();//FK
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
