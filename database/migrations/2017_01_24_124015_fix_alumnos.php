<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixAlumnos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->string('nombres');
            $table->string('apellidos');
            $table->integer('id_tipo_doc');
            $table->string('nro_doc');
            $table->string('email');
            $table->string('cel');
            $table->string('tel');
            $table->string('localidad');
            $table->integer('id_trabaja_en');
            $table->integer('id_funcion');
            $table->integer('id_provincia');
            $table->integer('id_tipo_convenio');
            $table->string('establecimiento1');
            $table->string('establecimiento2');
            $table->string('organismo1');
            $table->string('organismo2');
            $table->integer('id_pais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            //
        });
    }
}
