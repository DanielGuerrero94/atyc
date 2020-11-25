<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVAlumnosExcel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $statements = [];
        $statements[] = <<<HEREDOC
            DROP VIEW IF EXISTS alumnos.v_alumnos_excel;
HEREDOC;

        $statements[] = <<<HEREDOC
            CREATE VIEW alumnos.v_alumnos_excel as
                SELECT a.id_alumno,
                a.nombres,
                a.apellidos,
                t.id_tipo_documento,
                t.nombre AS tipo_documento,
                a.nro_doc,
                p.id_provincia,
                p.nombre AS provincia,
                g.nombre as genero,
                a.localidad as localidad,
                tr.nombre as trabajo,
                f.nombre as funcion,
                a.establecimiento1,
                a.establecimiento2,
                a.organismo1,
                a.organismo2,
                a.email,
                a.cel,
                a.tel
            FROM alumnos.alumnos a
                LEFT JOIN sistema.provincias p ON p.id_provincia = a.id_provincia
                LEFT JOIN sistema.tipos_documentos t ON t.id_tipo_documento = a.id_tipo_documento
                LEFT JOIN alumnos.generos g ON g.id_genero = a.id_genero
                LEFT JOIN alumnos.trabajos tr ON tr.id_trabajo = a.id_trabajo
                LEFT JOIN alumnos.funciones f ON f.id_funcion = a.id_funcion
            WHERE a.deleted_at IS NULL;
HEREDOC;

        foreach($statements as $statement) {
            DB::connection('pgsql')->statement($statement);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
