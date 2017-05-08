<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Fix001Profesors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profesors', function (Blueprint $table) {
          $table->string('nombres');
          $table->string('apellidos');
          $table->integer('tipo_doc');
          $table->string('nro_doc');
          $table->string('email')->nullable();
          $table->string('cel')->nullable();
          $table->string('tel')->nullable();

          $table->dropColumn(['id_persona','provincia','localidad','trabaja_en','funcion','convenio']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profesors', function (Blueprint $table) {
            //
        });
    }
}
