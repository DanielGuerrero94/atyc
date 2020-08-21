Despues de las migraciones sigue pendiente aclarar que es necesario correr db:seed para externas y crear las materialized views, principalmente lo que va fallar sino es el dashboard por los efectores.
Tambien se podria agregar en el codigo que si las variables no estan setedas simplemente se acepte como error porque no siempre voy a poder tener una coneccion con la tabla de efectores de produccion del sirge.

Importante tambien tener en cuenta que el script de database para hacer backup y store no esta trayendo las tablas intermedias cursos.cursos_alumnos y cursos.cusos_profesores

La vista materializada tampoco funciona en el dashboard
