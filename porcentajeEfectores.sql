SELECT substring(c.fecha::character varying from 1 for 7) as periodo, c.id_provincia,
count(distinct e.cuie) as capacitados,
(select case when count(distinct ee.cuie) = 0 then 
(select count(distinct cuie) 
from efectores.efectores
join efectores.convenio_administrativo con using(id_efector)) 
else count(distinct ee.cuie) end from efectores.efectores ee
join efectores.datos_geograficos dg on dg.id_efector = ee.id_efector
join efectores.convenio_administrativo con on con.id_efector = ee.id_efector
where dg.id_provincia::integer = c.id_provincia) as total
from cursos.cursos c
join cursos.cursos_alumnos ca on ca.id_curso = c.id_curso
join alumnos.alumnos a on a.id_alumno = ca.id_alumno
join efectores.efectores e on e.cuie = a.establecimiento1
join efectores.convenio_administrativo conv on conv.id_efector = e.id_efector
group by substring(c.fecha::character varying from 1 for 7), c.id_provincia
order by substring(c.fecha::character varying from 1 for 7), c.id_provincia