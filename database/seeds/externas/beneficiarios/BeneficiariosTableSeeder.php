<?php

use Illuminate\Database\Seeder;

class BeneficiariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("
        CREATE FOREIGN TABLE IF NOT EXISTS beneficiarios.beneficiarios
        (
            clave_beneficiario character varying(16) NOT NULL,
            apellido character varying(100) NOT NULL,
            nombre character varying(100) NOT NULL,
            tipo_documento character(3) NOT NULL,
            clase_documento character(1) NOT NULL,
            numero_documento character varying(14) NOT NULL,
            sexo character(1) NOT NULL,
            pais character varying(100),
            fecha_nacimiento date NOT NULL,
            fecha_inscripcion date NOT NULL,
            fecha_alta_efectiva date,
            id_provincia_alta character(2),
            discapacidad character(1),
            observaciones text,
            grupo_actual character(1),
            grupo_alta character(1)
        )
        SERVER ".env('SERVER_NAME')." ;");
    }
}
