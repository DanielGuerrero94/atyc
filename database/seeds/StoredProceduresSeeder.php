<?php

use Illuminate\Database\Seeder;

class StoredProceduresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creo las funciones de los reportes
        //Reporte 1

        \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_1(
    IN var_provincia integer,
    IN desde date,
    IN hasta date)
  RETURNS TABLE(provincia character varying, cantidad_alumnos bigint) AS
  $$
  BEGIN IF var_provincia = 0 THEN
  RETURN QUERY SELECT sub.provincia,count(*) as cantidad_alumnos FROM (SELECT A.id_alumno,P.nombre as provincia,sum(C.duracion) as horas_cursadas FROM alumnos.alumnos A
INNER JOIN cursos.cursos_alumnos CA ON A.id_alumno = CA.id_alumnos
INNER JOIN cursos.cursos C ON C.id_curso = CA.id_cursos
INNER JOIN sistema.provincias P on P.id_provincia = A.id_provincia
AND C.fecha 
BETWEEN desde
AND hasta
GROUP BY A.id_alumno,P.nombre
HAVING sum(C.duracion) >= 10
ORDER BY sum(C.duracion) DESC) as sub
GROUP BY sub.provincia;
ELSE RETURN QUERY 
SELECT sub.provincia,count(*) as cantidad_alumnos FROM (SELECT A.id_alumno,P.nombre as provincia,sum(C.duracion) as horas_cursadas FROM alumnos.alumnos A
INNER JOIN cursos.cursos_alumnos CA ON A.id_alumno = CA.id_alumnos
INNER JOIN cursos.cursos C ON C.id_curso = CA.id_cursos
INNER JOIN sistema.provincias P on P.id_provincia = A.id_provincia
AND C.fecha 
BETWEEN desde
AND hasta
AND A.id_provincia = var_provincia
GROUP BY A.id_alumno,P.nombre
HAVING sum(C.duracion) >= 10
ORDER BY sum(C.duracion) DESC) as sub
GROUP BY sub.provincia;
END IF;
END $$  LANGUAGE 'plpgsql'");        

        //Reporte 4
        \DB::statement("CREATE OR REPLACE FUNCTION reporte_4(provincia INT,desde date,hasta date) RETURNS TABLE (provincia character varying(20),capacitados bigint,total int,porcentaje float)
AS 'SELECT P.nombre as provincia,efectores_capacitados.capacitados,total_efectores.total,(CAST(efectores_capacitados.capacitados as float)*100)/CAST(total_efectores.total as float) as porcentaje FROM (
SELECT count(subA.capacitados) capacitados
FROM (SELECT A.establecimiento1 as capacitados,P.id_provincia as provincia FROM alumnos.alumnos A 
INNER JOIN cursos.cursos_alumnos CA ON A.id_alumno = CA.id_alumnos
INNER JOIN cursos.cursos C ON C.id_curso = CA.id_cursos
INNER JOIN sistema.provincias P on P.id_provincia = A.id_provincia
WHERE id_trabajo = 2 AND id_convenio = 3 
AND C.fecha 
BETWEEN desde	
AND hasta
AND A.id_provincia = provincia
GROUP BY A.establecimiento1,P.id_provincia) as subA
GROUP BY subA.provincia) as efectores_capacitados,
(SELECT suB.total FROM 
dblink(''dbname=sirge3 port=5432 host=192.6.0.66 user=postgres password=BernardoCafe008'',
    ''SELECT cast(count(*) as int) as total,CAST(DG.id_provincia as int) FROM efectores.efectores E
INNER JOIN efectores.datos_geograficos DG ON DG.id_efector = E.id_efector
GROUP BY DG.id_provincia'')
            AS suB(total int,id_provincia int) 
where suB.id_provincia = provincia) as total_efectores,
sistema.provincias P WHERE P.id_provincia = provincia' 
LANGUAGE SQL;");
    }
}
