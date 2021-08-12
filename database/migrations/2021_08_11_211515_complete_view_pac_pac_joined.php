<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompleteViewPacPacJoined extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS pac.pac_joined;');
        DB::statement(<<<HEREDOC

CREATE VIEW pac.pac_joined AS
    SELECT
        p.id_pac,
        p.nombre,
        p.id_accion,
        p.ediciones,
        p.id_provincia,
        p.created_at,
        p.updated_at,
        p.deleted_at,
        p.duracion,
        p.id_ficha_tecnica,
        p.anio,
        p.ficha_obligatoria,
        p.id_estado,
        p.id_actor,
        p.id_pauta,
        p.id_modalidad,
        c.fecha_plan_inicial AS fp_desde,
        c.fecha_plan_final AS fp_hasta,
        c.fecha_ejec_inicial AS fe_desde,
        c.fecha_ejec_final AS fe_hasta,
        c.id_estado AS id_estado_curso,
        le.numero AS linea_numero,
        le.nombre AS linea_nombre,
        ft.path AS ficha_tecnica_path,
        ft.original AS ficha_tecnica_original,
        ft.created_at AS ficha_tecnica_created_at,
        ft.updated_at AS ficha_tecnica_updated_at,
        ft.aprobada AS ficha_tecnica_aprobada,
        pro.nombre AS provincia,
        pt.id_tematica,
        pr.id_responsable,
        pd.id_destinatario,
        pc.id_componente
    FROM pac.pacs p
        JOIN cursos.lineas_estrategicas le ON le.id_linea_estrategica = p.id_accion
        LEFT JOIN pac.fichas_tecnicas ft ON ft.id_ficha_tecnica = p.id_ficha_tecnica
        LEFT JOIN cursos.cursos c USING (id_pac)
        JOIN sistema.provincias pro ON pro.id_provincia = p.id_provincia
        LEFT JOIN pac.pacs_tematicas pt USING (id_pac)
        LEFT JOIN pac.pacs_responsables pr USING (id_pac)
        LEFT JOIN pac.pacs_destinatarios pd USING (id_pac)
        LEFT JOIN pac.pacs_componentes pc USING (id_pac);
HEREDOC
        );
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
