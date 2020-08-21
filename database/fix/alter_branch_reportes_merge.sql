-- branch reportes-mergeados
update sistema.reportes set nombre = 'Reportes de PAC', view = 'reportes-pac' where id_reporte = 8;

delete from sistema.reportes where id_reporte in (9, 12);

update sistema.reportes set id_reporte = 9 where id_reporte = 10;
update sistema.reportes set id_reporte = 10 where id_reporte = 11;