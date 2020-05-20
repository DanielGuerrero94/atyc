-- alter table pac.fichas_tecnicas
-- add column aprobada boolean;

-- update pac.fichas_tecnicas aprobada
-- set aprobada = false;

alter table pac.pacs
add column ficha_obligatoria boolean;

update pac.pacs ficha_obligatoria
set ficha_obligatoria = true;
