<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CambiarColumnas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->renameColumn('nombres', 'nombre');
            $table->renameColumn('id_tipo_trabajo', 'id_area_tematica');
            $table->renameColumn('id_funcion', 'id_linea_estrategica');
            $table->date('fecha');
            $table->smallInteger('edicion');
            $table->float('duracion');
            $table->dropColumn(['apellidos', 'tipo_doc', 'nro_doc','email','cel','tel']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cursos', function (Blueprint $table) {
            //
        });
    }
}


