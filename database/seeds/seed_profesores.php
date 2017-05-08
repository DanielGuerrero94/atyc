<?php

use Illuminate\Database\Seeder;

class seed_profesores extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO public.profesors (id,nombres,apellidos,id_tipo_doc,nro_doc,email,cel,tel)
(SELECT
 sub.id, 
 sub.nombres,
 sub.apellidos,
 T.id as \"id_tipo_doc\",
 sub.nro_doc,
 sub.email,
 sub.cel,
 sub.tel
 FROM dblink('dbname=elearning port=5432 
     		host=192.6.0.66 user=postgres password=BernardoCafe008',
     		'SELECT * FROM g_plannacer.profesores')
     		AS sub(
     			id integer,
  nombres character varying(100),
  apellidos character varying(100),
  tipo_doc character varying(20),
  nro_doc character varying(20),
  email character varying(50),
  cel character varying(20),
  tel character varying(20)
  ) INNER JOIN public.tipo_docs T ON T.nombre = sub.tipo_doc)");
    }
}

