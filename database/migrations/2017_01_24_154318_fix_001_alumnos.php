<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Fix001Alumnos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('cel')->nullable()->change();
            $table->string('tel')->nullable()->change();
            $table->integer('id_tipo_convenio')->nullable()->change();
            $table->string('establecimiento1')->nullable()->change();
            $table->string('establecimiento2')->nullable()->change();
            $table->string('organismo1')->nullable()->change();
            $table->string('organismo2')->nullable()->change();
            $table->integer('id_pais')->nullable()->change();
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
