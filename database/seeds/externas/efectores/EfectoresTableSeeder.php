<?php

use Illuminate\Database\Seeder;

class EfectoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("
        CREATE FOREIGN TABLE IF NOT EXISTS efectores.efectores
        (
            id_efector serial NOT NULL,
            cuie character(6) NOT NULL,
            siisa character(14) NOT NULL,
            nombre character varying(200) NOT NULL,
            domicilio character varying(500) NOT NULL,
            codigo_postal character varying(8),
            denominacion_legal character varying(200),
            id_tipo_efector integer NOT NULL,
            rural character(1) NOT NULL DEFAULT 'N'::bpchar,
            cics character varying(1) NOT NULL DEFAULT 'N'::character varying,
            id_categorizacion integer NOT NULL,
            id_dependencia_administrativa integer NOT NULL,
            dependencia_sanitaria character varying(200),
            codigo_provincial_efector character varying(200),
            integrante character(1) NOT NULL DEFAULT 'N'::bpchar,
            compromiso_gestion character(1) NOT NULL DEFAULT 'N'::bpchar,
            priorizado character(1) NOT NULL DEFAULT 'N'::bpchar,
            ppac character(1) NOT NULL DEFAULT 'N'::bpchar,
            id_estado integer,
            created_at timestamp(0) without time zone,
            updated_at timestamp(0) without time zone,
            hcd character(1) NOT NULL DEFAULT 'N'::bpchar,
            id_sistema_hcd smallint
        )
        SERVER ".env('SERVER_NAME')." ;");
    }
}
