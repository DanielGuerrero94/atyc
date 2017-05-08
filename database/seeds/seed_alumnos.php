<?php

use Illuminate\Database\Seeder;

class seed_alumnos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO public.alumnos
(id,nombres,apellidos,id_tipo_doc,nro_doc,email,cel,tel,localidad,id_trabaja_en,id_funcion,id_provincia,id_tipo_convenio,establecimiento1,establecimiento2,organismo1,organismo2)
(SELECT
 sub.id, 
 sub.nombres,
 sub.apellidos,
 T.id as \"id_tipo_doc\",
 sub.nro_doc,
 sub.email,
 sub.cel,
 sub.tel,
 sub.localidad,
 TR.id as \"id_trabaja_en\",
 F.id as \"id_funcion\",
 sub.provincia as \"id_provincia\",
 C.id as \"id_tipo_convenio\",
 sub.establecimiento1,
 sub.establecimiento2,
 sub.organismo1,
 sub.organismo2
 FROM dblink('dbname=elearning port=5432 
     		host=192.6.0.66 user=postgres password=BernardoCafe008',
     		'SELECT * FROM g_plannacer.alumnos')
     		AS sub(id integer,
   nombres character varying(100),
   apellidos character varying(100),
   tipo_doc character varying(20),
   nro_doc character varying(20),
   email character varying(50),
   cel character varying(20),
   tel character varying(20),
   localidad character varying(300),
   trabaja_en character varying(300),
   funcion character varying(300),
   provincia integer,
   tipo_convenio character varying(100),
   establecimiento1 character varying(300),
   establecimiento2 character varying(300),
   organismo1 character varying(50),
   organismo2 character varying(300)) INNER JOIN public.tipo_docs T ON T.nombre = sub.tipo_doc INNER JOIN public.trabajas TR ON TR.nombre = sub.trabaja_en INNER JOIN public.funcions F ON F.nombre = sub.funcion INNER JOIN public.convenios C ON C.nombre = sub.tipo_convenio)");
    }
}


 