-- branch reportes-mergeados
-- update sistema.reportes set nombre = 'Reportes de PAC', view = 'reportes-pac' where id_reporte = 8;

-- delete from sistema.reportes where id_reporte in (9, 12);

-- branch master
insert into sistema.reportes (nombre, view, created_at) values
('Cantidad de Acciones Ejecutadas de PAC', 'ejecutadas-pac', now()),
('Porcentaje de Acciones Ejecutadas de PAC', 'porcentaje-ejecutadas-de-planificadas', now());

update sistema.reportes set id_reporte = 9 where id_reporte = 13;
update sistema.reportes set id_reporte = 12 where id_reporte = 14;