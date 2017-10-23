<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProfesoresTable02 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sistema.profesores', function (Blueprint $table) {
            DB::statement("
            ALTER TABLE sistema.profesores ALTER nro_doc TYPE INT USING nro_doc::integer
        ");
            $table->unique('nro_doc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sistema.profesores', function (Blueprint $table) {
            //
        });
    }
}
