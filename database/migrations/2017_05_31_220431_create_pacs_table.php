<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pac.pacs', function (Blueprint $table) {
            $table->increments('id_pac');
            $table->integer('id_alcance'):
            $table->integer('id_modalidad'):
            $table->integer('id_profundizacion'):
            $table->integer('id_destinatario'):
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
        Schema::dropIfExists('pac.pacs');
    }
}
