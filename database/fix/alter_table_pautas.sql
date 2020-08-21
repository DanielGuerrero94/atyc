alter table pac.pautas
add column id_provincia integer,
add constraint fk_provincia foreign key (id_provincia) references sistema.provincias (id_provincia) MATCH FULL;

update pac.pautas id_provincia
set id_provincia = 25;

alter table pac.categorias_pautas
add column numero integer;

update pac.categorias_pautas numero
set numero = id_categoria;

delete from pac.pautas_anios where id_pauta in(select id_pauta from pac.pautas where nombre = 'AC ESPECIFICAS');
delete from pac.pautas where nombre = 'AC ESPECIFICAS';

create sequence if not exists pac.categorias_id_categorias_seq start 7 owned by pac.categorias_pautas.id_categoria;
ALTER TABLE pac.categorias_pautas ALTER COLUMN id_categoria SET DEFAULT nextval('pac.categorias_id_categorias_seq');