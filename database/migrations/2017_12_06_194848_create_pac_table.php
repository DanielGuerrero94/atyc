<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac.pac', function (Blueprint $table) {
            $table->increments('id_pac');
            $table->string('trimestre_planificacion',2);
            $table->string('t1',1);
            $table->string('t2',1);
            $table->string('t3',1);
            $table->string('t4',1);
            $table->boolean('consul_peatyc');
            $table->text('observado');
            $table->integer('repeticiones');

            $table->integer('id_curso')->unsigned();
            $table->foreign('id_curso')->references('id_curso')->on('cursos.cursos');
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
         Schema::dropIfExists('pac.pac');
    }
}
