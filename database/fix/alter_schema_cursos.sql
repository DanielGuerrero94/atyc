--alter_schema_cursos.sql

drop table cursos.estados;

create sequence cursos.estados_id_estados;

create table cursos.estados (
	id_estado integer PRIMARY KEY DEFAULT nextval('cursos.estados_id_estados'),
	descripcion varchar(50) NOT NULL
);

insert into cursos.estados (descripcion) values
('Planificado'),
('Diseñado'),
('En ejecución'),
('Terminado'),
('Reprogramado'),
('Eliminado');

alter table cursos.cursos add column id_estado type integer;
update cursos.cursos set id_estado = 4; 
alter table cursos.cursos add constraint estadosfk foreign key (id_estado) references cursos.estados (id_estado) MATCH FULL;

alter table cursos.cursos rename column fecha to fecha_ejec_final;
alter table cursos.cursos add column id_pac type integer;
