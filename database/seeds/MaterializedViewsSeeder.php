<?php

use Illuminate\Database\Seeder;

class MaterializedViewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\DB::statement("CREATE MATERIALIZED VIEW efectores.mv_efectores_conveniados AS 
    		SELECT dg.id_provincia,
    		count(DISTINCT e.cuie) AS count
    		FROM efectores.efectores e
    		JOIN efectores.datos_geograficos dg USING (id_efector)
    		WHERE e.id_estado = 1 AND e.integrante = 'S'::bpchar AND e.compromiso_gestion = 'S'::bpchar
    		GROUP BY dg.id_provincia
    		UNION
    		SELECT '25'::bpchar AS id_provincia,
    		count(DISTINCT e.cuie) AS count
    		FROM efectores.efectores e
    		JOIN efectores.datos_geograficos dg USING (id_efector)
    		WHERE e.id_estado = 1 AND e.integrante = 'S'::bpchar AND e.compromiso_gestion = 'S'::bpchar
    		WITH DATA;");

    	\DB::statement("CREATE MATERIALIZED VIEW efectores.mv_reporte_4 AS 
    		SELECT p.id_provincia, pe.desde, pe.hasta,
    		CASE WHEN sub.capacitados IS NULL THEN 0::bigint
    		ELSE sub.capacitados
    		END AS capacitados,
    		CASE WHEN sub.total IS NULL THEN ( SELECT con.count
    		FROM efectores.mv_efectores_conveniados con
    		WHERE con.id_provincia::integer = p.id_provincia)
    		ELSE sub.total
    		END AS total,
    		CASE WHEN sub.capacitados IS NULL THEN 0::numeric
    		ELSE round(sub.capacitados::numeric * 100.0 / sub.total::numeric, 2)
    		END AS porcentaje
    		FROM sistema.provincias p
    		CROSS JOIN sistema.periodos pe
    		LEFT JOIN ( SELECT p_1.id_provincia, pe_1.desde, pe_1.hasta, count(DISTINCT e.cuie) AS capacitados,
    		( SELECT con.count
    		FROM efectores.mv_efectores_conveniados con
    		WHERE con.id_provincia::integer = p_1.id_provincia) AS total
    		FROM sistema.provincias p_1
    		JOIN cursos.cursos c ON c.id_provincia = p_1.id_provincia
    		JOIN cursos.cursos_alumnos ca ON ca.id_curso = c.id_curso
    		JOIN alumnos.alumnos a ON a.id_alumno = ca.id_alumno
    		JOIN efectores.efectores e ON e.cuie = a.establecimiento1::bpchar
    		CROSS JOIN sistema.periodos pe_1
    		WHERE c.fecha_ejec_final >= pe_1.desde AND c.fecha_ejec_final <= pe_1.hasta AND e.id_estado = 1 AND e.integrante = 'S'::bpchar
    		AND e.compromiso_gestion = 'S'::bpchar
    		GROUP BY p_1.id_provincia, pe_1.desde, pe_1.hasta) sub ON sub.id_provincia = p.id_provincia AND
    		sub.desde = pe.desde AND sub.hasta = pe.hasta
    		ORDER BY p.id_provincia, pe.desde, pe.hasta
    		WITH DATA;");
    }
}
