<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuestas.encuestas', function (Blueprint $table) {
            $table->increments('id_encuesta');
            $table->integer('id_curso');//FK
            $table->integer('id_pregunta');//FK
            $table->integer('id_respuesta');//FK
            $table->integer('cantidad');
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
        Schema::dropIfExists('encuestas.encuestas');
    }
}
