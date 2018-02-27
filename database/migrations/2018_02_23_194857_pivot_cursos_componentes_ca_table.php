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
        Schema::create('pac.pacs_componentes_ca', function (Blueprint $table) {
            $table->primary(['id_pac', 'id_componente_ca']);
            $table->integer('id_pac')->unsigned();
            $table->integer('id_componente_ca')->unsigned();

            $table->foreign('id_pac')->references('id_pac')->on('pac.pac');
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
        Schema::dropIfExists('pac.pacs_componentes_ca');
    }
}
