-- insert into sistema.reportes (nombre, view, created_at) values
-- ('Provincias con PAC', 'provincias-con-pac', now()),
-- ('Cantidad de Acciones Planificadas en PAC', 'planificadas-pac', now()),
-- ('Cantidad de Acciones Ejecutadas de PAC', 'ejecutadas-pac', now()),
-- ('Cantidad de Acciones con Ficha Técnica en PAC', 'fichas-tecnicas-pac', now()),
-- ('Cantidad de Pautas PAC', 'pautas-pac', now());

insert into sistema.reportes (nombre, view, created_at) values
('Porcentaje de Acciones Ejecutadas de PAC', 'porcentaje-ejecutadas-de-planificadas', now());