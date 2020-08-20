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
        $this->reporte1();
        $this->reporte2();
        $this->reporte3();
        $this->reporte4();
        $this->reporte5();
        $this->reporte6();
        $this->reporte7();
        $this->reporte8();
        $this->reporte9();
        $this->reporte10();
        $this->reporte11();
        $this->reporte12();
    }

    /**
     *
     *
     * @return void
     */
    public function reporte1()
    {
        \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_1(
        IN var_provincia integer,
        IN desde date,
        IN hasta date)
        RETURNS TABLE(provincia character varying, cantidad_alumnos bigint) AS
        \$BODY\$
        BEGIN IF var_provincia = 0 THEN
        RETURN QUERY SELECT sub.provincia,count(*) as cantidad_alumnos FROM (SELECT A.id_alumno,P.nombre as provincia,
        sum(C.duracion) as horas_cursadas FROM alumnos.alumnos A
        INNER JOIN cursos.cursos_alumnos CA ON A.id_alumno = CA.id_alumno
        INNER JOIN cursos.cursos C ON C.id_curso = CA.id_curso
        INNER JOIN sistema.provincias P on P.id_provincia = A.id_provincia
        AND C.fecha_ejec_inicial 
        BETWEEN desde
        AND hasta
        GROUP BY A.id_alumno,P.nombre
        HAVING sum(C.duracion) >= 10
        ORDER BY sum(C.duracion) DESC) as sub
        GROUP BY sub.provincia;
        ELSE RETURN QUERY 
        SELECT sub.provincia,count(*) as cantidad_alumnos FROM (SELECT A.id_alumno,P.nombre as provincia,
        sum(C.duracion) as horas_cursadas FROM alumnos.alumnos A
        INNER JOIN cursos.cursos_alumnos CA ON A.id_alumno = CA.id_alumno
        INNER JOIN cursos.cursos C ON C.id_curso = CA.id_curso
        INNER JOIN sistema.provincias P on P.id_provincia = A.id_provincia
        AND C.fecha_ejec_inicial 
        BETWEEN desde
        AND hasta
        AND A.id_provincia = var_provincia
        GROUP BY A.id_alumno,P.nombre
        HAVING sum(C.duracion) >= 10
        ORDER BY sum(C.duracion) DESC) as sub
        GROUP BY sub.provincia;
        END IF;
        END \$BODY\$
        LANGUAGE plpgsql VOLATILE
        COST 100
        ROWS 1000;");
    }

    public function reporte2()
    {
        \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_2(
        IN var_provincia integer,
        IN desde date,
        IN hasta date)
        RETURNS TABLE(provincia character varying, cantidad_alumnos bigint) AS
        \$BODY\$
        BEGIN IF var_provincia = 0 THEN
        RETURN QUERY SELECT sub.provincia,count(*) as cantidad_alumnos FROM (SELECT A.id_alumno,P.nombre as provincia,
        sum(C.duracion) as horas_cursadas FROM alumnos.alumnos A
        INNER JOIN cursos.cursos_alumnos CA ON A.id_alumno = CA.id_alumno
        INNER JOIN cursos.cursos C ON C.id_curso = CA.id_curso
        INNER JOIN sistema.provincias P on P.id_provincia = A.id_provincia
        WHERE (A.id_trabajo = 2 OR A.id_trabajo = 3)
        AND C.fecha_ejec_inicial 
        BETWEEN desde
        AND hasta
        GROUP BY A.id_alumno,P.nombre
        HAVING sum(C.duracion) >= 10
        ORDER BY sum(C.duracion) DESC) as sub
        GROUP BY sub.provincia;
        ELSE RETURN QUERY 
        SELECT sub.provincia,count(*) as cantidad_alumnos FROM (SELECT A.id_alumno,P.nombre as provincia,
        sum(C.duracion) as horas_cursadas FROM alumnos.alumnos A
        INNER JOIN cursos.cursos_alumnos CA ON A.id_alumno = CA.id_alumno
        INNER JOIN cursos.cursos C ON C.id_curso = CA.id_curso
        INNER JOIN sistema.provincias P on P.id_provincia = A.id_provincia
        WHERE (A.id_trabajo = 2 OR A.id_trabajo = 3)
        AND C.fecha_ejec_inicial 
        BETWEEN desde
        AND hasta
        AND A.id_provincia = var_provincia
        GROUP BY A.id_alumno,P.nombre
        HAVING sum(C.duracion) >= 10
        ORDER BY sum(C.duracion) DESC) as sub
        GROUP BY sub.provincia;
        END IF;
        END \$BODY\$
        LANGUAGE plpgsql VOLATILE
        COST 100
        ROWS 1000;");
    }

    public function reporte3()
    {
        \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_3(
        IN var_provincia integer,
        IN desde date,
        IN hasta date)
        RETURNS TABLE(provincia character varying, cantidad_alumnos bigint) AS
        \$BODY\$
        BEGIN IF var_provincia = 0 THEN
        RETURN QUERY SELECT sub.provincia,count(*) as cantidad_alumnos FROM (SELECT A.id_alumno,
        P.nombre as provincia FROM alumnos.alumnos A
        INNER JOIN cursos.cursos_alumnos CA ON A.id_alumno = CA.id_alumno
        INNER JOIN cursos.cursos C ON C.id_curso = CA.id_curso
        INNER JOIN sistema.provincias P on P.id_provincia = A.id_provincia
        WHERE C.fecha_ejec_inicial 
        BETWEEN desde
        AND hasta
        GROUP BY A.id_alumno,P.nombre) as sub
        GROUP BY sub.provincia;
        ELSE RETURN QUERY
        SELECT sub.provincia,count(*) as cantidad_alumnos FROM (SELECT A.id_alumno,P.nombre as provincia 
        FROM alumnos.alumnos A
        INNER JOIN cursos.cursos_alumnos CA ON A.id_alumno = CA.id_alumno
        INNER JOIN cursos.cursos C ON C.id_curso = CA.id_curso
        INNER JOIN sistema.provincias P on P.id_provincia = A.id_provincia
        WHERE C.fecha_ejec_inicial 
        BETWEEN desde
        AND hasta
        AND A.id_provincia = var_provincia
        GROUP BY A.id_alumno,P.nombre) as sub
        GROUP BY sub.provincia;
        END IF;
        END \$BODY\$
        LANGUAGE plpgsql VOLATILE
        COST 100
        ROWS 1000;");
    }

    public function reporte4()
    {
        \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_4(
        IN var_provincia integer,
        IN desde date,
        IN hasta date)
        RETURNS TABLE(provincia character varying, capacitados bigint, total bigint, porcentaje numeric) AS
        \$BODY\$
        BEGIN IF var_provincia = 0 THEN
        RETURN QUERY select p.nombre as provincia,
        case when sub.capacitados is null then 0 
        else sub.capacitados
          end,
        case when sub.total is null then 
        (select count(distinct e.cuie) 
        from efectores.efectores e
        join efectores.datos_geograficos dg using (id_efector)
        where dg.id_provincia::integer = p.id_provincia)
        else sub.total
          end,
        case when sub.capacitados is null then 0 
        else round(sub.capacitados * 100.0 / sub.total,2)
          end as porcentaje 
        from sistema.provincias p 
        left join 
        (select p.id_provincia, count(distinct e.cuie) as capacitados,
        case when p.id_provincia = 25 then 
        (select count(*) 
        from efectores.efectores e)
        else (select count(distinct e.cuie) 
          from efectores.efectores e
        join efectores.datos_geograficos dg using (id_efector)
        where dg.id_provincia::integer = p.id_provincia) 
        end as total
        from sistema.provincias as p
        left join cursos.cursos as c on c.id_provincia = p.id_provincia
        left join cursos.cursos_alumnos as ca on ca.id_curso = c.id_curso
        left join alumnos.alumnos as a on a.id_alumno = ca.id_alumno
        left join efectores.efectores as e on e.cuie = a.establecimiento1
        where c.fecha_ejec_inicial between desde and hasta
        and e.integrante = 'S' and e.compromiso_gestion = 'S'
        group by p.id_provincia) as sub on sub.id_provincia = p.id_provincia
        order by p.id_provincia;
        ELSE RETURN QUERY
        select p.nombre as provincia,
        case when sub.capacitados is null then 0 
        else sub.capacitados
          end,
        case when sub.total is null then 
        (select count(distinct e.cuie) 
        from efectores.efectores e
        join efectores.datos_geograficos dg using (id_efector)
        where dg.id_provincia::integer = p.id_provincia)
        else sub.total
          end,
        case when sub.capacitados is null then 0 
        else round(sub.capacitados * 100.0 / sub.total,2)
          end as porcentaje 
        from sistema.provincias p 
        left join 
        (select p.id_provincia, count(distinct e.cuie) as capacitados,
        case when p.id_provincia = 25 then 
        (select count(*) 
        from efectores.efectores e)
        else (select count(distinct e.cuie) 
          from efectores.efectores e
        join efectores.datos_geograficos dg using (id_efector)
        where dg.id_provincia::integer = p.id_provincia) 
        end as total
        from sistema.provincias as p
        left join cursos.cursos as c on c.id_provincia = p.id_provincia
        left join cursos.cursos_alumnos as ca on ca.id_curso = c.id_curso
        left join alumnos.alumnos as a on a.id_alumno = ca.id_alumno
        left join efectores.efectores as e on e.cuie = a.establecimiento1
        where c.fecha_ejec_inicial between desde and hasta
        group by p.id_provincia) as sub on sub.id_provincia = p.id_provincia
        where p.id_provincia = var_provincia
        order by p.id_provincia;
        END IF;
        END \$BODY\$
        LANGUAGE plpgsql VOLATILE
        COST 100
        ROWS 1000;");
    }

    public function reporte5()
    {
        \DB::statement("DROP FUNCTION public.reporte_5(integer,date,date)");
        \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_5(
        IN var_provincia integer,
        IN desde date,
        IN hasta date)
        RETURNS TABLE(provincia character varying, nombre character varying, edicion smallint, fecha_ejec_inicial date,
        cantidad_alumnos bigint, tipologia text, tematica character varying, duracion double precision) AS
        \$BODY\$
        BEGIN IF var_provincia = 0 THEN
        RETURN QUERY SELECT P.nombre as provincia,C.nombre,C.edicion,C.fecha_ejec_inicial,count (*) as cantidad_alumnos,
        CONCAT(LE.numero,'-',LE.nombre) as tipologia,AT.nombre as tematica,C.duracion from cursos.cursos C 
        left join cursos.cursos_alumnos CA ON CA.id_curso = C.id_curso 
        left join alumnos.alumnos A ON CA.id_alumno = A.id_alumno
        inner join sistema.provincias P ON P.id_provincia = C.id_provincia
        inner join cursos.areas_tematicas AT ON AT.id_area_tematica = C.id_area_tematica 
        inner join cursos.lineas_estrategicas LE ON LE.id_linea_estrategica = C.id_linea_estrategica
        where C.fecha_ejec_inicial between desde and hasta
        group by C.id_curso,C.nombre,LE.numero,LE.nombre,AT.nombre,P.nombre;
        ELSE RETURN QUERY
        SELECT P.nombre as provincia,C.nombre,C.edicion,C.fecha_ejec_inicial,count (*) as cantidad_alumnos,
        CONCAT(LE.numero,'-',LE.nombre) as tipologia,AT.nombre as tematica,C.duracion from cursos.cursos C 
        left join cursos.cursos_alumnos CA ON CA.id_curso = C.id_curso 
        left join alumnos.alumnos A ON CA.id_alumno = A.id_alumno
        inner join sistema.provincias P ON P.id_provincia = C.id_provincia
        inner join cursos.areas_tematicas AT ON AT.id_area_tematica = C.id_area_tematica 
        inner join cursos.lineas_estrategicas LE ON LE.id_linea_estrategica = C.id_linea_estrategica
        where C.fecha_ejec_inicial between desde and hasta 
        and c.id_provincia = var_provincia
        group by C.id_curso,C.nombre,LE.numero,LE.nombre,AT.nombre,P.nombre;
        END IF;
        END \$BODY\$
        LANGUAGE plpgsql VOLATILE
        COST 100
        ROWS 1000;");
    }

    public function reporte6()
    {
        \DB::statement("DROP FUNCTION public.reporte_6(integer,date,date)");
        \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_6(
        IN var_provincia integer,
        IN var_desde date,
        IN var_hasta date)
        RETURNS TABLE(provincia character varying, cuie character, efector character varying,
        denominacion_legal character varying, departamento character varying, localidad character varying,
        accion character varying, fecha_ejec_inicial date, participantes bigint) AS
        \$BODY\$
        BEGIN IF var_provincia = 0 THEN
        RETURN QUERY select p.descripcion as provincia, e.cuie, e.nombre as efector, e.denominacion_legal ,
        d.nombre_departamento as departamento, l.nombre_localidad as localidad, c.nombre as accion, c.fecha_ejec_inicial,
        count(*) as participantes 
        from efectores.efectores as e 
        inner join efectores.datos_geograficos as dg on dg.id_efector = e.id_efector 
        inner join geo.provincias as p on p.id_provincia = dg.id_provincia 
        inner join geo.departamentos as d on d.id = dg.id_departamento 
        inner join geo.localidades as l on l.id = dg.id_localidad 
        inner join alumnos.alumnos as a on a.establecimiento1 = e.cuie 
        inner join cursos.cursos_alumnos as ca on ca.id_alumno = a.id_alumno 
        inner join cursos.cursos as c on c.id_curso = ca.id_curso 
        where c.fecha_ejec_inicial between var_desde and var_hasta
        group by  p.descripcion, e.cuie, e.nombre, e.denominacion_legal, d.nombre_departamento, l.nombre_localidad,
        c.nombre, c.fecha_ejec_inicial;
        ELSE RETURN QUERY
        select p.descripcion as provincia, e.cuie, e.nombre as efector, e.denominacion_legal ,
        d.nombre_departamento as departamento, l.nombre_localidad as localidad, c.nombre as accion, c.fecha_ejec_inicial,
        count(*) as participantes 
        from efectores.efectores as e 
        inner join efectores.datos_geograficos as dg on dg.id_efector = e.id_efector 
        inner join geo.provincias as p on p.id_provincia = dg.id_provincia 
        inner join geo.departamentos as d on d.id = dg.id_departamento 
        inner join geo.localidades as l on l.id = dg.id_localidad 
        inner join alumnos.alumnos as a on a.establecimiento1 = e.cuie 
        inner join cursos.cursos_alumnos as ca on ca.id_alumno = a.id_alumno 
        inner join cursos.cursos as c on c.id_curso = ca.id_curso 
        where c.fecha_ejec_inicial between var_desde and var_hasta
        and dg.id_provincia::integer = var_provincia
        group by  p.descripcion, e.cuie, e.nombre, e.denominacion_legal, d.nombre_departamento, l.nombre_localidad,
        c.nombre, c.fecha_ejec_inicial;
        END IF;
        END \$BODY\$
        LANGUAGE plpgsql VOLATILE
        COST 100
        ROWS 1000;");
    }

    public function reporte7()
    {
      \DB::statement("DROP FUNCTION IF EXISTS public.reporte_7(integer, date, date)");
      \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_7(
      IN var_provincia integer,
      IN var_desde date,
      IN var_hasta date)
      RETURNS TABLE(provincia character varying, cumple text) AS
      \$BODY\$
      BEGIN IF var_provincia = 0 THEN
      RETURN QUERY
      select p.nombre as provincia, case when count(*) > 0 then 'Sí'::text else 'No'::text end as cumple
      from pac.pacs as pa
      inner join sistema.provincias as p on p.id_provincia = pa.id_provincia
      left join cursos.cursos as c on c.id_pac = pa.id_pac
      where (
        case when c.fecha_ejec_inicial is null then
          c.fecha_plan_inicial between var_desde and var_hasta
          or c.fecha_plan_final between var_desde and var_hasta
        else
          c.fecha_ejec_inicial between var_desde and var_hasta
          or c.fecha_ejec_final between var_desde and var_hasta
        end)
      and pa.deleted_at is null
      and c.deleted_at is null
      group by p.nombre;
      ELSE RETURN QUERY
      select p.nombre as provincia, (case when count(*) > 0 then 'Sí'::text else 'No'::text end) as cumple
      from pac.pacs as pa
      inner join sistema.provincias as p on p.id_provincia = pa.id_provincia
      left join cursos.cursos as c on c.id_pac = pa.id_pac
      where (
        case when c.fecha_ejec_inicial is null then
            c.fecha_plan_inicial between var_desde and var_hasta
            or c.fecha_plan_final between var_desde and var_hasta
          else
            c.fecha_ejec_inicial between var_desde and var_hasta
            or c.fecha_ejec_final between var_desde and var_hasta
          end)
      and pa.id_provincia = var_provincia
      and pa.deleted_at is null
      and c.deleted_at is null
      group by p.nombre;
      END IF;
      END \$BODY\$
      LANGUAGE plpgsql VOLATILE
      COST 100
      ROWS 1000;");
    }

    public function reporte8()
    {
      \DB::statement("DROP FUNCTION IF EXISTS public.reporte_8(integer, date, date)");
      \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_8(
        IN var_provincia integer,
        IN var_desde date,
        IN var_hasta date)
        RETURNS TABLE (provincia character varying, cantidad_planificadas bigint) AS
        \$BODY\$
        BEGIN IF var_provincia = 0 THEN
        RETURN QUERY
        select p.nombre as provincia, count(*) as cantidad_planificadas
        from cursos.cursos as c
        inner join pac.pacs as pa on c.id_pac = pa.id_pac
        inner join sistema.provincias as p on p.id_provincia = c.id_provincia
        where (
          case when c.fecha_ejec_inicial is null then
            c.fecha_plan_inicial between var_desde and var_hasta
            or c.fecha_plan_final between var_desde and var_hasta
          else
            c.fecha_ejec_inicial between var_desde and var_hasta
            or c.fecha_ejec_final between var_desde and var_hasta
          end)
        and pa.deleted_at is null
        and c.deleted_at is null
        group by p.nombre;
        ELSE RETURN QUERY
        select p.nombre as provincia, count(*) as cantidad_planificadas
        from cursos.cursos as c
        inner join pac.pacs as pa on c.id_pac = pa.id_pac
        inner join sistema.provincias as p on p.id_provincia = c.id_provincia
        where (
          case when c.fecha_ejec_inicial is null then
            c.fecha_plan_inicial between var_desde and var_hasta
            or c.fecha_plan_final between var_desde and var_hasta
          else
            c.fecha_ejec_inicial between var_desde and var_hasta
            or c.fecha_ejec_final between var_desde and var_hasta
          end)
        and c.id_provincia = var_provincia
        and pa.deleted_at is null
        and c.deleted_at is null
        group by p.nombre;
        END IF;
        END \$BODY\$
        LANGUAGE plpgsql VOLATILE
        COST 100
        ROWS 1000;");
    }

    public function reporte9()
    {
      \DB::statement("DROP FUNCTION IF EXISTS public.reporte_9(integer, date, date)");
      \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_9(
        IN var_provincia integer,
        IN var_desde date,
        IN var_hasta date)
        RETURNS TABLE (provincia character varying, cantidad_ejecutadas bigint) AS
        \$BODY\$
        BEGIN IF var_provincia = 0 THEN
        RETURN QUERY
        select p.nombre as provincia, count(*) as cantidad_ejecutadas
        from cursos.cursos as c
        inner join pac.pacs as pa on c.id_pac = pa.id_pac
        inner join sistema.provincias as p on p.id_provincia = c.id_provincia
        where c.id_estado between 3 and 4
        and (
          case when c.fecha_ejec_inicial is null then
            c.fecha_plan_inicial between var_desde and var_hasta
            or c.fecha_plan_final between var_desde and var_hasta
          else
            c.fecha_ejec_inicial between var_desde and var_hasta
            or c.fecha_ejec_final between var_desde and var_hasta
          end)
        and pa.deleted_at is null
        and c.deleted_at is null
        group by p.nombre;
        ELSE RETURN QUERY
        select p.nombre as provincia, count(*) as cantidad_ejecutadas
        from cursos.cursos as c
        inner join pac.pacs as pa on c.id_pac = pa.id_pac
        inner join sistema.provincias as p on p.id_provincia = c.id_provincia
        where c.id_estado between 3 and 4
        and (
          case when c.fecha_ejec_inicial is null then
            c.fecha_plan_inicial between var_desde and var_hasta
            or c.fecha_plan_final between var_desde and var_hasta
          else
            c.fecha_ejec_inicial between var_desde and var_hasta
            or c.fecha_ejec_final between var_desde and var_hasta
          end)
        and c.id_provincia = var_provincia
        and pa.deleted_at is null
        and c.deleted_at is null
        group by p.nombre;
        END IF;
        END \$BODY\$
        LANGUAGE plpgsql VOLATILE
        COST 100
        ROWS 1000;");
    }

    public function reporte10()
    {
      \DB::statement("DROP FUNCTION IF EXISTS public.reporte_10(integer, date, date)");
      \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_10(
        IN var_provincia integer,
        IN var_desde date,
        IN var_hasta date)
        RETURNS TABLE (provincia character varying, cantidad_diseniadas bigint) AS
        \$BODY\$
        BEGIN IF var_provincia = 0 THEN
        RETURN QUERY
        select p.nombre as provincia, count(*) as cantidad_diseniadas
        from cursos.cursos as c
        left join pac.pacs as pa on c.id_pac = pa.id_pac
        inner join sistema.provincias as p on p.id_provincia = c.id_provincia
        where pa.id_ficha_tecnica is not null
        and (
          case when c.fecha_ejec_inicial is null then
            c.fecha_plan_inicial between var_desde and var_hasta
            or c.fecha_plan_final between var_desde and var_hasta
          else
            c.fecha_ejec_inicial between var_desde and var_hasta
            or c.fecha_ejec_final between var_desde and var_hasta
          end)
        and pa.deleted_at is null
        and c.deleted_at is null
        group by p.nombre;
        ELSE RETURN QUERY
        select p.nombre as provincia, count(*) as cantidad_diseniadas
        from cursos.cursos as c
        left join pac.pacs as pa on c.id_pac = pa.id_pac
        inner join sistema.provincias as p on p.id_provincia = c.id_provincia
        where pa.id_ficha_tecnica is not null
        and (
          case when c.fecha_ejec_inicial is null then
            c.fecha_plan_inicial between var_desde and var_hasta
            or c.fecha_plan_final between var_desde and var_hasta
          else
            c.fecha_ejec_inicial between var_desde and var_hasta
            or c.fecha_ejec_final between var_desde and var_hasta
          end)
        and c.id_provincia = var_provincia
        and pa.deleted_at is null
        and c.deleted_at is null
        group by p.nombre;
        END IF;
        END \$BODY\$
        LANGUAGE plpgsql VOLATILE
        COST 100
        ROWS 1000;");
    }

    public function reporte11()
    {
      \DB::statement("DROP FUNCTION IF EXISTS public.reporte_11(integer, date, date)");
      \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_11(
        IN var_provincia integer,
        IN var_desde date,
        IN var_hasta date)
        RETURNS TABLE (provincia character varying, numero_categoria text, cantidad_categoria bigint) AS
        \$BODY\$
        BEGIN IF var_provincia = 0 THEN
        RETURN QUERY
        select pr.nombre as provincia, cat.numero || ' - ' || cat.nombre  as numero_categoria, count(*) as cantidad_categoria
        from cursos.cursos as c
        inner join pac.pacs as pa on c.id_pac = pa.id_pac
        inner join pac.pacs_pautas as pp on pa.id_pac = pp.id_pac
        inner join pac.pautas as pau on pp.id_pauta = pau.id_pauta
        inner join sistema.provincias as pr on pa.id_provincia = pr.id_provincia
        inner join pac.categorias_pautas as cat on pau.id_categoria = cat.id_categoria
        where (
          case when c.fecha_ejec_inicial is null then
            c.fecha_plan_inicial between var_desde and var_hasta
            or c.fecha_plan_final between var_desde and var_hasta
          else
            c.fecha_ejec_inicial between var_desde and var_hasta
            or c.fecha_ejec_final between var_desde and var_hasta
          end)
        and pa.deleted_at is null
        and c.deleted_at is null
        group by pr.nombre, cat.nombre, cat.numero;
        ELSE RETURN QUERY
        select pr.nombre as provincia, cat.numero || ' - ' || cat.nombre as numero_categoria, count(*) as cantidad_categoria
        from cursos.cursos as c
        inner join pac.pacs as pa on c.id_pac = pa.id_pac
        inner join pac.pacs_pautas as pp on pa.id_pac = pp.id_pac
        inner join pac.pautas as pau on pp.id_pauta = pau.id_pauta
        inner join sistema.provincias as pr on pa.id_provincia = pr.id_provincia
        inner join pac.categorias_pautas as cat on pau.id_categoria = cat.id_categoria
        where (
          case when c.fecha_ejec_inicial is null then
            c.fecha_plan_inicial between var_desde and var_hasta
            or c.fecha_plan_final between var_desde and var_hasta
          else
            c.fecha_ejec_inicial between var_desde and var_hasta
            or c.fecha_ejec_final between var_desde and var_hasta
          end)
        and pa.id_provincia = var_provincia
        and pa.deleted_at is null
        and c.deleted_at is null
        group by pr.nombre, cat.nombre, cat.numero;
        END IF;
        END \$BODY\$
        LANGUAGE plpgsql VOLATILE
        COST 100
        ROWS 1000;");
    }

    public function reporte12()
    {
      \DB::statement("DROP FUNCTION IF EXISTS public.reporte_12(integer, date, date)");
      \DB::statement("CREATE OR REPLACE FUNCTION public.reporte_12(
        IN var_provincia integer,
        IN var_desde date,
        IN var_hasta date)
        RETURNS TABLE (provincia character varying, porcentaje numeric) AS
        \$BODY\$
        BEGIN IF var_provincia = 0 THEN
        RETURN QUERY
        select p.nombre as provincia,
        case when count(*) = 0 then 0.00 else round((100.00 * sum(case when c.id_estado between 3 and 4 then 1 else 0 end) / count(*)), 2) end as porcentaje
        from cursos.cursos as c
        inner join pac.pacs as pa on c.id_pac = pa.id_pac
        inner join sistema.provincias as p on p.id_provincia = c.id_provincia
        where (
          case when c.fecha_ejec_inicial is null then
            c.fecha_plan_inicial between var_desde and var_hasta
            or c.fecha_plan_final between var_desde and var_hasta
          else
            c.fecha_ejec_inicial between var_desde and var_hasta
            or c.fecha_ejec_final between var_desde and var_hasta
          end)
        and pa.deleted_at is null
        and c.deleted_at is null
        group by p.nombre;
        ELSE RETURN QUERY
        select p.nombre as provincia,
        case when count(*) = 0 then 0.00 else round((100.00 * sum(case when c.id_estado between 3 and 4 then 1 else 0 end) / count(*)), 2) end as porcentaje
        from cursos.cursos as c
        inner join pac.pacs as pa on c.id_pac = pa.id_pac
        inner join sistema.provincias as p on p.id_provincia = c.id_provincia
        where (
          case when c.fecha_ejec_inicial is null then
            c.fecha_plan_inicial between var_desde and var_hasta
            or c.fecha_plan_final between var_desde and var_hasta
          else
            c.fecha_ejec_inicial between var_desde and var_hasta
            or c.fecha_ejec_final between var_desde and var_hasta
          end)
        and c.id_provincia = var_provincia
        and pa.deleted_at is null
        and c.deleted_at is null
        group by p.nombre;
        END IF;
        END \$BODY\$
        LANGUAGE plpgsql VOLATILE
        COST 100
        ROWS 1000;");
    }

}