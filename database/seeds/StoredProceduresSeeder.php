<?php

use Illuminate\Database\Seeder;

class StoredProceduresSeeder extends Seeder
{
    /**
     * Crea las funciones y stored procedures
     *
     * @return void
     */
    public function run()
    {
      $this->reporte_1();
      $this->reporte_2();
      $this->reporte_3();
      $this->reporte_4();      
    }

    /**
     * 
     *
     * @return void
     */
    public function reporte_1()
    {
      \DB::statemen("CREATE OR REPLACE FUNCTION public.reporte_1(
        IN var_provincia integer,
        IN desde date,
        IN hasta date)
      RETURNS TABLE(provincia character varying, cantidad_alumnos bigint) AS
      $BODY$
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
      END $BODY$
      LANGUAGE plpgsql VOLATILE
      COST 100
      ROWS 1000;");
    }

    public function reporte_2()
    {
      \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_2(
        IN var_provincia integer,
        IN desde date,
        IN hasta date)
      RETURNS TABLE(provincia character varying, cantidad_alumnos bigint) AS
      $BODY$
      BEGIN IF var_provincia = 0 THEN
      RETURN QUERY SELECT sub.provincia,count(*) as cantidad_alumnos FROM (SELECT A.id_alumno,P.nombre as provincia,sum(C.duracion) as horas_cursadas FROM alumnos.alumnos A
        INNER JOIN cursos.cursos_alumnos CA ON A.id_alumno = CA.id_alumnos
        INNER JOIN cursos.cursos C ON C.id_curso = CA.id_cursos
        INNER JOIN sistema.provincias P on P.id_provincia = A.id_provincia
        WHERE (A.id_trabajo = 2 OR A.id_trabajo = 3)
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
        WHERE (A.id_trabajo = 2 OR A.id_trabajo = 3)
        AND C.fecha 
        BETWEEN desde
        AND hasta
        AND A.id_provincia = var_provincia
        GROUP BY A.id_alumno,P.nombre
        HAVING sum(C.duracion) >= 10
        ORDER BY sum(C.duracion) DESC) as sub
      GROUP BY sub.provincia;
      END IF;
      END $BODY$
      LANGUAGE plpgsql VOLATILE
      COST 100
      ROWS 1000;");
    }

    public function reporte_3()
    {
      \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_3(
        IN var_provincia integer,
        IN desde date,
        IN hasta date)
      RETURNS TABLE(provincia character varying, cantidad_alumnos bigint) AS
      $BODY$
      BEGIN IF var_provincia = 0 THEN
      RETURN QUERY SELECT sub.provincia,count(*) as cantidad_alumnos FROM (SELECT A.id_alumno,P.nombre as provincia FROM alumnos.alumnos A
        INNER JOIN cursos.cursos_alumnos CA ON A.id_alumno = CA.id_alumnos
        INNER JOIN cursos.cursos C ON C.id_curso = CA.id_cursos
        INNER JOIN sistema.provincias P on P.id_provincia = A.id_provincia
        WHERE C.fecha 
        BETWEEN desde
        AND hasta
        GROUP BY A.id_alumno,P.nombre) as sub
      GROUP BY sub.provincia;
      ELSE RETURN QUERY
      SELECT sub.provincia,count(*) as cantidad_alumnos FROM (SELECT A.id_alumno,P.nombre as provincia FROM alumnos.alumnos A
        INNER JOIN cursos.cursos_alumnos CA ON A.id_alumno = CA.id_alumnos
        INNER JOIN cursos.cursos C ON C.id_curso = CA.id_cursos
        INNER JOIN sistema.provincias P on P.id_provincia = A.id_provincia
        WHERE C.fecha 
        BETWEEN desde
        AND hasta
        AND A.id_provincia = var_provincia
        GROUP BY A.id_alumno,P.nombre) as sub
      GROUP BY sub.provincia;
      END IF;
      END $BODY$
      LANGUAGE plpgsql VOLATILE
      COST 100
      ROWS 1000;");
    }

    public function reporte_4()
    {
      \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_4(
        IN provincia integer,
        IN desde date,
        IN hasta date)
      RETURNS TABLE(provincia character varying, capacitados bigint, total integer, porcentaje double precision) AS
      $BODY$SELECT P.nombre as provincia,efectores_capacitados.capacitados,total_efectores.total,(CAST(efectores_capacitados.capacitados as float)*100)/CAST(total_efectores.total as float) as porcentaje FROM (
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
        dblink('dbname=sirge3 port=5432 host=192.6.0.66 user=postgres password=BernardoCafe008',
          'SELECT cast(count(*) as int) as total,CAST(DG.id_provincia as int) FROM efectores.efectores E
          INNER JOIN efectores.datos_geograficos DG ON DG.id_efector = E.id_efector
          GROUP BY DG.id_provincia')
        AS suB(total int,id_provincia int) 
        where suB.id_provincia = provincia) as total_efectores,
      sistema.provincias P WHERE P.id_provincia = provincia$BODY$
      LANGUAGE sql VOLATILE
      COST 100
      ROWS 1000;");
    }
  }
