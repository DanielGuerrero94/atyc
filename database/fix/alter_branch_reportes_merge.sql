-- branch reportes-mergeados
update sistema.reportes set nombre = 'Reportes de PAC', view = 'reportes-pac' where id_reporte = 8;

delete from sistema.reportes where id_reporte in (9, 12);

