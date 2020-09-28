-- branch reportes-mergeados
update sistema.reportes set nombre = 'Reportes de PAC', view = 'reportes-pac' where id_reporte = 8;

delete from sistema.reportes where id_reporte in (9, 12);

update sistema.reportes set id_reporte = 9 where id_reporte = 10;
update sistema.reportes set id_reporte = 10 where id_reporte = 11;

-- branch master

update sistema.reportes set id_reporte = 11 where id_reporte = 10;
update sistema.reportes set id_reporte = 10 where id_reporte = 9;
update sistema.reportes set nombre = 'Cantidad de Acciones Planificadas en PAC', view = 'planificadas-pac' where id_reporte = 8;


insert into sistema.reportes (nombre, view, created_at) values
('Cantidad de Acciones Ejecutadas de PAC', 'ejecutadas-pac', now()),
('Porcentaje de Acciones Ejecutadas de PAC', 'porcentaje-ejecutadas-de-planificadas', now());

update sistema.reportes set id_reporte = 9 where view = 'ejecutadas-pac';
update sistema.reportes set id_reporte = 12 where view = 'porcentaje-ejecutadas-de-planificadas';
alter sequence sistema.reportes_id_reporte_seq restart with 12;