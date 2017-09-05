<?php

use Illuminate\Database\Seeder;

class ConvenioAdministrativoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("
            CREATE FOREIGN TABLE IF NOT EXISTS efectores.convenio_administrativo
            (
            id_convenio serial NOT NULL,
            id_efector integer NOT NULL,
            numero_compromiso character varying(50) NOT NULL,
            firmante character varying(200) NOT NULL,
            nombre_tercer_administrador character varying(200),
            codigo_tercer_administrador character varying(50),
            fecha_suscripcion date NOT NULL,
            fecha_inicio date NOT NULL,
            fecha_fin date NOT NULL,
            created_at timestamp(0) without time zone,
            updated_at timestamp(0) without time zone
            )
            SERVER ".env('SERVER_NAME')." ;");
    }
}
