create materialized view efectores.mv_efectores_conveniados_2 as
SELECT dg.id_provincia,
    count(DISTINCT e.cuie) AS count
   FROM efectores.efectores e
     JOIN efectores.datos_geograficos dg USING (id_efector)
  WHERE e.id_estado = 1 --AND e.integrante = 'S'::bpchar AND e.compromiso_gestion = 'S'::bpchar
  GROUP BY dg.id_provincia
UNION
 SELECT '25'::bpchar AS id_provincia,
    count(DISTINCT e.cuie) AS count
   FROM efectores.efectores e
     JOIN efectores.datos_geograficos dg USING (id_efector)
  WHERE e.id_estado = 1 --AND e.integrante = 'S'::bpchar AND e.compromiso_gestion = 'S'::bpchar;
