alter table pac.pacs
add column anio integer;

update pac.pacs anio
set anio = 2020;