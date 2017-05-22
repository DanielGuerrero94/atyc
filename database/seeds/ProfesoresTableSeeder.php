<?php

use Illuminate\Database\Seeder;

class ProfesoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
        *   En el caso que se haga otra migracion correr primero esto
        *   update g_plannacer.profesores set tipo_doc = upper(tipo_doc)
        */

        \DB::statement("INSERT INTO sistema.profesores (id_profesor,nombres,apellidos,id_tipo_documento,nro_doc,email,cel,tel)
        (SELECT
        sub.id as id_profesor, 
        sub.nombres,
        sub.apellidos,
        T.id_tipo_documento as \"id_tipo_documento\",
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
        ) INNER JOIN sistema.tipos_documentos T ON T.nombre = sub.tipo_doc)");
    }
}

