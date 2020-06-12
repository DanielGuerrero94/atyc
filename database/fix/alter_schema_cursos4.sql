alter table cursos.cursos
add column 'fecha_display' date;

update cursos.cursos fecha_display
set fecha_display = fecha_ejec_inicial
where fecha_ejec_inicial is not null;

update cursos.cursos fecha_display
set fecha_display = fecha_plan_inicial
where fecha_ejec_inicial is null;

insert into cursos.cursos_areas_tematicas (id_curso, id_area_tematica)
select c.id_curso, c.id_area_tematica from cursos.cursos_areas_tematicas cat
right join cursos.cursos c on cat.id_area_tematica = c.id_area_tematica and cat.id_curso = c.id_curso
where cat.id_area_tematica is null and cat.id_curso is null;