<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMatrizPacsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriz_pacs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trimestre_planificacion',2);
            $table->integer('t1');
            $table->integer('t2');
            $table->integer('t3');
            $table->integer('t4');
            $table->boolean('consul_peatyc');
            $table->string('observado',450);
            $table->integer('repeticiones');

            $table->integer('id_estado')->unsigned();
            $table->integer('id_provincia')->unsigned();
            $table->integer('id_tipo_action')->unsigned();
            $table->integer('id_sumarte_taller')->unsigned();
            $table->integer('id_action_capacitation')->unsigned();

            $table->foreign('id_estado')->references('id')->on('estados');
            $table->foreign('id_provincia')->references('id')->on('provincias');
            $table->foreign('id_tipo_action')->references('id')->on('tipos_actions');
            $table->foreign('id_sumarte_taller')->references('id')->on('sumarte_tallers');
            $table->foreign('id_action_capacitation')->references('id')->on('actions_capacitations');            
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
        Schema::dropIfExists('matriz_pacs');
    }
}
