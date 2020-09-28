-- areas_tematicas
-- Eston son los que no estaban en el excel 2020 pac

-- update cursos.areas_tematicas
-- set deleted_at = now()
-- where id_area_tematica in (
-- 1,12,9,11,13,14,15,16,17,18,19,20,22,28,30,31,36);

--insert into cursos.areas_tematicas ("nombre") values
--('ODP'),
--('USO DE FONDOS'),
--('POBLACION OBJETIVO'), 
--('GENEROS'), 
--('CORONAVIRUS'),
--('MEJORA CONTINUA'),
--('DBT'),
--('INFARTO'),
--('OTRA TEMATICA');

--UPDATE cursos.areas_tematicas
--set nombre = 'POBLACION INDIGENA - INTERCULTURALIDAD EN SALUD'
--where nombre = 'CONTENIDOS FORMATIVOS EN SALUD INTERCULTURAL Y PUEBLOS INDIGENAS';

--UPDATE cursos.areas_tematicas
--set nombre = 'COMPETENCIAS DE HABILIDADES Y CONDUCTA'
--where nombre = 'CONTENIDOS FORMATIVOS EN COMPETENCIAS DE HABILIDADES Y CONDUCTA';

--UPDATE cursos.areas_tematicas
--set nombre = 'COMPETENCIAS DE GESTION EN SALUD'
--where nombre = 'CONTENIDOS FORMATIVOS EN COMPETENCIAS DE GESTION EN SALUD';

--UPDATE cursos.areas_tematicas
--set nombre = 'PROMOCION Y PREVENCION DE LA SALUD Y ABORDAJE DESDE UNA PERSPECTIVA DE DERECHOS'
--where nombre = 'CONTENIDOS FORMATIVOS EN PROMOCION Y PREVENCION DE LA SALUD Y ABORDAJE DESDE UNA PERSPECTIVA DE DERECHOS';

--lineas_estrategicas
--UPDATE cursos.lineas_estrategicas
--set deleted_at = now()
--where id_linea_estrategica < 20;

DROP VIEW cursos_joined_alumnos;

DROP VIEW cursos_joined;

alter table cursos.lineas_estrategicas alter column "numero" type varchar(8);

insert into cursos.lineas_estrategicas ("numero","nombre") values
('1.1', 'PRES - CURSO'),
('1.2', 'PRES - ENTRENAMIENTO LABORAL'),
('1.3', 'PRES - PASANTIAS'), 
('1.4.1', 'PRES - SEMINARIOS'), 
('1.4.2', 'PRES - CHARLAS REFLEXIVAS'),
('1.4.3', 'PRES - JORNADAS'),
('1.4.4', 'PRES - TALLERES'),
('2.1', 'VIRTUAL - CURSO AUTOADMINISTRADO SIN TUTORIA'),
('2.2', 'VIRTUAL - CURSO AUTOADMINISTRADO CON ACOMPAÑAMIENTO DE TUTORES'),
('2.3', 'VIRTUAL -  CURSO CON TUTORIA'),
('2.4', 'VIRTUAL - AULA DE SEMIPRESENCIAL'),
('2.5', 'VIRTUAL - ENTORNO VIRTUAL DE ENTRENAMIENTO LABORAL'),
('2.6', 'VIRTUAL - ESPACIO FORO'),
('3.', 'VISITAS DE MONITOREO / SUPERVISIÓN'),
('4', 'SEMIPRES - CURSO');

CREATE VIEW cursos_joined_alumnos AS
 SELECT c.id_curso,
    c.nombre,
    c.id_provincia,
    c.id_area_tematica,
    c.id_linea_estrategica,
    c.fecha_ejec_final AS fecha,
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
    c.fecha_ejec_final AS fecha,
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

--ALTER TABLE pac.pacs_tematicas
--DROP CONSTRAINT fk_tematica;

--ALTER TABLE pac.pacs_tematicas 
--add constraint fk_tematica foreign key (id_tematica)
--references cursos.areas_tematicas (id_area_tematica)
--MATCH FULL;

--ALTER TABLE pac.pacs
--DROP CONSTRAINT fk_tipo_accion;

--ALTER TABLE pac.pacs 
--add constraint fk_tipo_accion foreign key (id_accion)
--references cursos.lineas_estrategicas (id_linea_estrategica)
--MATCH FULL;
