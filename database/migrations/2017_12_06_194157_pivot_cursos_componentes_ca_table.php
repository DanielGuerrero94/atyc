<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PivotCursosComponentesCaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos.cursos_componentes_ca', function(Blueprint $table){
            $table->integer('id_curso')->unsigned();
            $table->integer('id_componente_ca')->unsigned();

            $table->foreign('id_curso')->references('id_curso')->on('cursos.cursos');
            $table->foreign('id_componente_ca')->references('id_componente_ca')->on('pac.componentes_ca');
            
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
        Schema::dropIfExists('cursos.cursos_componentes_ca');
    }
}
