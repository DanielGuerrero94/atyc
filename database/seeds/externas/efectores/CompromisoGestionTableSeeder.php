<?php

use Illuminate\Database\Seeder;

class CompromisoGestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("
        CREATE FOREIGN TABLE IF NOT EXISTS efectores.compromiso_gestion
        (
            id_compromiso serial NOT NULL,
            id_efector integer NOT NULL,
            numero_compromiso character varying(50) NOT NULL,
            firmante character varying(200) NOT NULL,
            fecha_suscripcion date NOT NULL,
            fecha_inicio date NOT NULL,
            fecha_fin date NOT NULL,
            pago_indirecto character varying(1) NOT NULL DEFAULT 'N'::character varying,
            created_at timestamp(0) without time zone,
            updated_at timestamp(0) without time zone
        )
        SERVER ".env('SERVER_NAME')." ;");
    }
}
