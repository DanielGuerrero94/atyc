alter table pac.fichas_tecnicas
add column aprobada boolean;

update pac.fichas_tecnicas aprobada
set aprobada = false;