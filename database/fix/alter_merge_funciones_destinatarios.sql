alter table alumnos.funciones add column updated_at date;
alter table alumnos.funciones add column created_at date;
alter table pac.pacs_destinatarios drop constraint fk_destinatario;
alter table pac.pacs_destinatarios add constraint fk_destinatario foreign key (id_destinatario) references alumnos.funciones (id_funcion) MATCH FULL;
drop table pac.destinatarios;
drop table pac.tipos_accion;
drop table pac.tematicas;
