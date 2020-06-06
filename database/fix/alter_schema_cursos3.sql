DROP VIEW pac.pac_joined;
drop materialized view efectores.mv_reporte_4_2;
DROP VIEW cursos_joined_alumnos;
DROP VIEW cursos_joined;

alter table cursos.cursos drop column fecha_ejec_inicial;
alter table cursos.cursos rename column fecha_ejec_final TO fecha_ejec_inicial;
alter table cursos.cursos add column fecha_ejec_final date; 

CREATE OR REPLACE VIEW pac.pac_joined AS
 SELECT p.id_pac,
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
    c.fecha_plan_inicial AS fp_desde,
    c.fecha_plan_final AS fp_hasta,
    c.fecha_ejec_inicial AS fe_desde,
    c.fecha_ejec_final AS fe_hasta,
    le.numero AS linea_numero,
    le.nombre AS linea_nombre,
    ft.path AS ficha_tecnica_path,
    ft.original AS ficha_tecnica_original,
    ft.created_at AS ficha_tecnica_created_at,
    ft.updated_at AS ficha_tecnica_updated_at,
    ft.aprobada AS ficha_tecnica_aprobada,
    pro.nombre AS provincia,
    pt.id_tematica,
    pp.id_pauta,
    pr.id_responsable,
    pd.id_destinatario,
    pc.id_componente
   FROM (((((((((pac.pacs p
     JOIN cursos.lineas_estrategicas le ON ((le.id_linea_estrategica = p.id_accion)))
     LEFT JOIN pac.fichas_tecnicas ft ON ((ft.id_ficha_tecnica = p.id_ficha_tecnica)))
     LEFT JOIN cursos.cursos c USING (id_pac))
     JOIN sistema.provincias pro ON ((pro.id_provincia = p.id_provincia)))
     LEFT JOIN pac.pacs_tematicas pt USING (id_pac))
     LEFT JOIN pac.pacs_pautas pp USING (id_pac))
     LEFT JOIN pac.pacs_responsables pr USING (id_pac))
     LEFT JOIN pac.pacs_destinatarios pd USING (id_pac))
     LEFT JOIN pac.pacs_componentes pc USING (id_pac));

ALTER TABLE pac.pac_joined OWNER TO postgres;

create materialized view efectores.mv_reporte_4_2 as
SELECT p.id_provincia,
    pe.desde,
    pe.hasta,
        CASE
            WHEN sub.capacitados IS NULL THEN 0::bigint
            ELSE sub.capacitados
        END AS capacitados,
        CASE
            WHEN sub.total IS NULL THEN ( SELECT con.count
               FROM efectores.mv_efectores_conveniados_2 con
              WHERE con.id_provincia::integer = p.id_provincia)
            ELSE sub.total
        END AS total,
        CASE
            WHEN sub.capacitados IS NULL THEN 0::numeric
            ELSE round(sub.capacitados::numeric * 100.0 / sub.total::numeric, 2)
        END AS porcentaje
   FROM sistema.provincias p
     CROSS JOIN sistema.periodos pe
     LEFT JOIN ( SELECT p_1.id_provincia,
            pe_1.desde,
            pe_1.hasta,
            count(DISTINCT e.cuie) AS capacitados,
            ( SELECT con.count
                   FROM efectores.mv_efectores_conveniados_2 con
                  WHERE con.id_provincia::integer = p_1.id_provincia) AS total
           FROM sistema.provincias p_1
             JOIN cursos.cursos c ON c.id_provincia = p_1.id_provincia
             JOIN cursos.cursos_alumnos ca ON ca.id_curso = c.id_curso
             JOIN alumnos.alumnos a ON a.id_alumno = ca.id_alumno
             JOIN efectores.efectores e ON e.cuie = a.establecimiento1::bpchar
             CROSS JOIN sistema.periodos pe_1
          WHERE c.fecha_ejec_inicial >= pe_1.desde AND c.fecha_ejec_inicial <= pe_1.hasta AND e.id_estado = 1 AND e.integrante = 'S'::bpchar
          GROUP BY p_1.id_provincia, pe_1.desde, pe_1.hasta) sub ON sub.id_provincia = p.id_provincia AND sub.desde = pe.desde AND sub.hasta = pe.hasta
  ORDER BY p.id_provincia, pe.desde, pe.hasta;


CREATE VIEW cursos_joined_alumnos AS
 SELECT c.id_curso,
    c.nombre,
    c.id_provincia,
    c.id_area_tematica,
    c.id_linea_estrategica,
    c.fecha_ejec_inicial AS fecha,
    c.duracion,
    c.edicion,
    c.created_at,
    c.updated_at,
    c.deleted_at,
	ca.id_alumno,
    p.descripcion AS provincia,
    at.nombre AS area_tematica,
    le.numero,
    le.nombre AS linea_estrategica
   FROM cursos.cursos c
     JOIN geo.provincias p ON p.id_provincia = c.id_provincia::character varying::bpchar
     JOIN cursos.areas_tematicas at USING (id_area_tematica)
     JOIN cursos.lineas_estrategicas le USING (id_linea_estrategica)
     JOIN cursos.cursos_alumnos ca USING (id_curso)
	 JOIN alumnos.alumnos a USING (id_alumno);

CREATE VIEW cursos_joined AS
SELECT c.id_curso,
    c.nombre,
    c.id_provincia,
    c.id_area_tematica,
    c.id_linea_estrategica,
    c.fecha_ejec_inicial AS fecha,
    c.duracion,
    c.edicion,
    c.created_at,
    c.updated_at,
    c.deleted_at,
    p.descripcion AS provincia,
    a.nombre AS area_tematica,
    l.numero,
    l.nombre AS linea_estrategica
   FROM cursos.cursos c
     JOIN geo.provincias p ON p.id_provincia = c.id_provincia::character varying::bpchar
     JOIN cursos.areas_tematicas a USING (id_area_tematica)
     JOIN cursos.lineas_estrategicas l USING (id_linea_estrategica);