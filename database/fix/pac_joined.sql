--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.1
-- Dumped by pg_dump version 12.2 (Ubuntu 12.2-4)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: pac_joined; Type: VIEW; Schema: public; Owner: postgres
--

DROP VIEW pac.pac_joined;

CREATE OR REPLACE VIEW pac.pac_joined AS
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

--
-- PostgreSQL database dump complete
--

