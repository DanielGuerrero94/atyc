-- Destinatarios

alter sequence pac.destinatarios_id_destinatario_seq restart with 10;

-- Responsables

create sequence if not exists pac.responsables_id_responsable_seq start 4 owned by pac.responsables.id_responsable;
ALTER TABLE pac.responsables ALTER COLUMN id_responsable SET DEFAULT nextval('pac.responsables_id_responsable_seq');

-- Componentes 

ALTER TABLE componentes_cai
RENAME TO componentes;

create sequence if not exists pac.componentes_id_componente_seq start 12 owned by pac.componentes.id_componente;
ALTER TABLE pac.componentes ALTER COLUMN id_componente SET DEFAULT nextval('pac.componentes_id_componente_seq');

alter table pac.componentes
add column numero varchar(8);

UPDATE pac.componentes
set nombre = 'PLANIFICACIÓN DE TRANSFERENCIAS FINANCIERAS',
numero = 'A'
where nombre = 'A PLANIFICACIÓN DE TRANSFERENCIAS FINANCIERAS';

UPDATE pac.componentes
set nombre = 'CONFORMACION DE EQ DE SALUD FLIAR Y COMUNITARIA',
numero = 'B.1'
where nombre = 'B.1 CONFORMACION DE EQ DE SALUD FLIAR Y COMUNITARIA';

UPDATE pac.componentes
set nombre = 'ASIGNACION DE POBLACION A EQ DE SALUD',
numero = 'B.2'
where nombre = 'B.2 ASIGNACION DE POBLACION A EQ DE SALUD';

UPDATE pac.componentes
set nombre = 'INDICADORES SANITARIOS',
numero = 'C.1'
where nombre = 'C.1 INDICADORES SANITARIOS';

UPDATE pac.componentes
set nombre = 'PLAN DE EVALUACION Y MEJORA DE CALIDAD DE ATENCION',
numero = 'C.2'
where nombre = 'C.2 PLAN DE EVALUACION Y MEJORA DE CALIDAD DE ATENCION ';

UPDATE pac.componentes
set nombre = 'SISTEMAS DE INFORMACION INTEROPERABLES Y APLICACIONES INFORMATICAS',
numero = 'D'
where nombre = 'D SISTEMAS DE INFORMACION INTEROPERABLES Y APLICACIONES INFORMATICAS';

UPDATE pac.componentes
set nombre = 'PLAN DE CAPACITACION',
numero = 'E.1'
where nombre = 'E.1 PLAN DE CAPACITACION';

UPDATE pac.componentes
set nombre = 'PLAN DE COMUNICACIÓN Y EMPODERAMIENTO CIUDADANO',
numero = 'E.2'
where nombre = 'E.2 PLAN DE COMUNICACIÓN Y EMPODERAMIENTO CIUDADANO';

UPDATE pac.componentes
set nombre = 'PLAN DE PUEBLOS INDIGENAS',
numero = 'E.3'
where nombre = 'E.3 PLAN DE PUEBLOS INDIGENAS';

UPDATE pac.componentes
set nombre = 'PLAN DE SALVAGUARDA AMBIENTAL',
numero = 'E.4'
where nombre = 'E.4 PLAN DE SALVAGUARDA AMBIENTAL';

UPDATE pac.componentes
set nombre = 'PROMOCION DE LA SALUD',
numero = 'F'
where nombre = 'F PROMOCION DE LA SALUD';

-- Pautas

alter sequence pac.pautas_id_pauta_seq restart with 16;

alter table pac.pautas
add column numero varchar(8);

alter table pac.pautas
add column descripcion varchar(1000);

alter table pac.pautas
add column ficha_obligatoria boolean;

UPDATE pac.pautas
set nombre = 'AC EQ PROV',
numero = '1.1',
ficha_obligatoria = true,
descripcion = 'Diseñar una acción de capacitación de inducción para los nuevos integrantes del equipo de la UIP. Planificar la ejecución del mismo incluyendo en sus contenidos el uso del sistema de Gestión de Documentación Electrónica (GDE) y otros, en función de las necesidades detectadas y las demandas recibidas al respecto.'
where nombre = '1.1 AC EQ PROV';

UPDATE pac.pautas
set nombre = 'AC EQ PROV',
numero = '1.2',
descripcion = 'Realizar el curso "Nuevos Virus Respiratorios, incluido el COVID/19: métodos de detección, prevención, respuesta y control" de la Organización Mundial de la Salud y difundirlo ente los equipos de salud.
Más información disponible en el Espacio de Trabajo de Capacitación de ls Plataforma Virtual de Salud'
where nombre = '1.2 AC EQ PROV';

UPDATE pac.pautas
set nombre = 'AC ESTRATEGIAS',
numero = '2.1',
descripcion = 'Asociar alguna acción de Capacitación al OBJETIVO GENERAL DEL PROGRAMA SUMAR N°1 y sus indicadores asociados*

*Objetivo General el Programa 1:  Incrementar la cobertura efectiva y equitativa de servicios de salud priorizados brindados a la población elegible.  Indicadores:  1.1 Proporción de población elegible con Cobertura Efectiva Básica,1.2 Proporción de adultos elegibles con HTA que son diagnosticados en las regiones con resultados de salud más bajos, 1.3 Proporción de personas hipertensas que reciben tratamiento farmacológico.'
where nombre = '2.1 AC ESTRATEGIAS';

UPDATE pac.pautas
set nombre = 'AC ESTRATEGIAS',
numero = '2.2',
descripcion = 'Planificar la realización de las acciones de capacitación teniendo en cuenta el criterio de Distribución Equitativa de las mismas en toda la jurisdicción, para contribuir al cumplimiento del OBJETIVO GENERAL DEL PROGRAMA SUMAR  N°1.'
where nombre = '2.2 AC ESTRATEGIAS';

UPDATE pac.pautas
set nombre = 'AC ESTRATEGIAS',
numero = '2.3',
descripcion = 'Promover la incorporación de todos los actores articulados en las acciones de capacitación planificadas al Sistema de Gestión de Capacitaciones , contribuyendo al cumplimiento del OBJETIVO GENERAL DEL PROGRAMA SUMAR N°2* 

*Objetivo General el Programa 2: Incrementar la capacidad institucional del MSN y de los MSPs para implementar mecanismos de integración del sistema de salud, que involucra a diferentes actores clave de la provisión y financiamiento de salud.'
where nombre = '2.3 AC ESTRATEGIAS';

UPDATE pac.pautas
set nombre = 'AC ESTRATEGIAS',
numero = '2.4',
ficha_obligatoria = true,
descripcion = 'Planificar acciones para la implementación de la herramienta Plan de Evaluación y Mejora de la Calidad en el Primer Nivel de Atención dentro de la estrategia de Mejora Continua del área, teniendo en  cuenta que deben contribuir al cumplimiento de los IVT 3* y IVT 4* del programa Proteger

*IVT3: Porcentaje de establecimientos públicos de atención primaria de salud priorizados certificados para proveer servicios de salud de calidad para la detección y control de enfermedades crónicas no transmisibles” 

*IVT4: Porcentaje de establecimientos públicos de atención primaria de salud priorizados que realizan procesos de mejora para la provisión de servicios de calidad en enfermedades crónicas no transmisibles”'
where nombre = '2.4 AC ESTRATEGIAS';

UPDATE pac.pautas
set nombre = 'AC IMPLEMENTACION',
numero = '3.1',
ficha_obligatoria = true,
descripcion = 'Diseñar e implementar una accion de capacitación sobre  conceptos generales  y/o específicos del SUMAR-REDES-PROTEGER , que estén alineados con los conceptos que en forma paulatina se comenzarán a distribuir desde Nacion.'
where nombre = '3.1 AC IMPLEMENTACION';

UPDATE pac.pautas
set nombre = 'AC IMPLEMENTACION',
numero = '3.2',
ficha_obligatoria = true,
descripcion = 'Diseñar acción de capacitación de inducción para los nuevos integrantes del equipo  de los efectores "Induccion a efectores". Planificar la ejecución del mismo en función de las necesidades detectadas y las demandas recibidas al respecto'
where nombre = '3.2 AC IMPLEMENTACION';

UPDATE pac.pautas
set nombre = 'AC VIRTUAL',
numero = '4.1',
ficha_obligatoria = true,
descripcion = 'Desarrollo de acciones de capacitación virtuales. (incluirlos en la "Matriz de la PAC" )'
where nombre = '4.1 AC VIRTUAL';

UPDATE pac.pautas
set nombre = 'AC VIRTUAL',
numero = '4.2',
descripcion = 'Planificar, según propuesta de la ECP, la realización de los cursos disponibles en la Plataforma Virtual de Salud, a saber: 
Cursos de Formación en la Estrategia de Salud Familiar y Comunitaria; Cursos de "Introducción a la Historia Clínica Electrónica" , "Uso de la CIE 10" y "Mañanas de StÁndares Interoperables"; Curso sobre "Gestión Integral de Residuos en Establecimientos de Salud"; Curso "Implementación integral del Plan de Servicios de Salud "; y próximos diseños a informar**'
where nombre = '4.2 AC VIRTUAL';

UPDATE pac.pautas
set nombre = 'AC COMUNICACION',
numero = '5.1',
descripcion = 'Registrar en la PAC las actividades lúdicas o de información a la comunidad  en donde participará  el Área Fortalecimiento de las Competencias para la Gestión Sanitaria y Salvaguardas, según el indicador Actividades Comunitarias del Componente del CAI 2020 "E.2 Plan de comunicación y empoderamiento ciudadanoEstrategia de comunicación y empoderamiento ciudadano"

Indicador del área de Comunicación:
Actividades Comunitarias: Generar 4 actividades (lúdicas o de información a la comunidad) que incluyan la participación ciudadana, equipos de salud, miembros de otros programas del ministerio provincial u organizaciones del tercer sector. Las actividades deben desarrollarse en espacios públicos y tener como eje la promoción los programas Sumar, Redes y Proteger, los derechos y sus prestaciones, como acciones de promoción de la salud.'
where nombre = '5.1 AC COMUNICACION';

UPDATE pac.pautas
set nombre = 'AC ESPECIFICAS',
numero = '6.1'
where nombre = '6.1 AC ESPECIFICAS';

UPDATE pac.pautas
set nombre = 'AC ESPECIFICAS',
numero = '6.2'
where nombre = '6.2 AC ESPECIFICAS ';

UPDATE pac.pautas
set nombre = 'AC ESPECIFICAS',
numero = '6.3'
where nombre = '6.3 AC ESPECIFICAS';

UPDATE pac.pautas
set nombre = 'AC ESPECIFICAS',
numero = '6.4'
where nombre = '6.4 AC ESPECIFICAS';

update pac.pautas
set ficha_obligatoria = false
where ficha_obligatoria is null;

create table pac.pautas_anios (
    id_pauta integer not null,
    anio integer not null,
	PRIMARY KEY (id_pauta, anio)
);

alter table pac.pautas_anios
add constraint pautasfk foreign key (id_pauta) references pac.pautas (id_pauta) MATCH FULL;

insert into pac.pautas_anios (id_pauta, anio) values
(1, 2020),
(2, 2020),
(3, 2020),
(4, 2020),
(5, 2020),
(6, 2020),
(7, 2020),
(8, 2020),
(9, 2020),
(10, 2020),
(11, 2020),
(12, 2020),
(13, 2020),
(14, 2020),
(15, 2020);