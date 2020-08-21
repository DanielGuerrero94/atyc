--alter_schema_pacs.sql
alter table pac.pacs drop column fecha;
alter table pac.pacs alter column nombre type varchar(255);
alter table pac.pacs rename column id_tipo_accion to id_accion;

create sequence pac.ficha_tecnica_id;

create table pac.fichas_tecnicas (
  id_ficha_tecnica integer PRIMARY KEY DEFAULT nextval('pac.ficha_tecnica_id'),
  path varchar(255),
  original varchar(255),
  created_at timestamp without time zone,
  updated_at timestamp without time zone,
  deleted_at timestamp without time zone  
);

alter table pac.pacs drop column ficha_tecnica;
alter table pac.pacs add column id_ficha_tecnica integer;

drop table pac.pacs_cursos;
