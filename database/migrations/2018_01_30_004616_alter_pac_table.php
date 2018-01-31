<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPacTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pac.pac', function (Blueprint $table) {
            $table->dropColumn('consul_peatyc');
            $table->dropColumn('trimestre_planificacion');
            $table->integer('id_provincia')->unsigned()->default(1);
            $table->dropColumn('t1');
            $table->dropColumn('t2');
            $table->dropColumn('t3');
            $table->dropColumn('t4');
            $table->foreign('id_provincia')->references('id_provincia')->on('sistema.provincias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pac.pac', function (Blueprint $table) {
            $table->boolean('consul_peatyc');
            $table->string('trimestre_planificacion',2);
            $table->string('t1',1);
            $table->string('t2',1);
            $table->string('t3',1);
            $table->string('t4',1);
        });
    }
}
