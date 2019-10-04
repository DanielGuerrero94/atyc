--ERROR CABA dio de alta alumnos de manera programatica al parecer, se crearon con fecha 2018-08-03 y con minutos y segundos que solo puede lograr un algoritmo
update alumnos.alumnos set created_at = '2018-02-11 01:01:25' where created_at::date = '2018-08-03';
update alumnos.alumnos set updated_at = '2018-02-11 01:01:25' where updated_at::date = '2018-08-03';
