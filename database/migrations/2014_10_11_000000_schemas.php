<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Schemas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	if (env('DB_CONNECTION') === "pgsq") {
        \DB::statement('CREATE EXTENSION IF NOT EXISTS dblink');
        \DB::statement('CREATE EXTENSION IF NOT EXISTS postgres_fdw');
        \DB::statement('CREATE SCHEMA IF NOT EXISTS alumnos');
        \DB::statement('CREATE SCHEMA IF NOT EXISTS cursos');
        \DB::statement('CREATE SCHEMA IF NOT EXISTS encuestas');
        \DB::statement('CREATE SCHEMA IF NOT EXISTS pac');
        \DB::statement('CREATE SCHEMA IF NOT EXISTS sistema');
        \DB::statement('CREATE SCHEMA IF NOT EXISTS beneficiarios');
        \DB::statement('CREATE SCHEMA IF NOT EXISTS efectores');
        \DB::statement('CREATE SCHEMA IF NOT EXISTS geo');
	\DB::statement('CREATE SCHEMA IF NOT EXISTS dw');
	}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP SCHEMA alumnos CASCADE');
        \DB::statement('DROP SCHEMA cursos CASCADE');
        \DB::statement('DROP SCHEMA encuestas CASCADE');
        \DB::statement('DROP SCHEMA pac CASCADE');
        \DB::statement('DROP SCHEMA sistema CASCADE');
        \DB::statement('DROP SCHEMA beneficiarios CASCADE');
        \DB::statement('DROP SCHEMA efectores CASCADE');
        \DB::statement('DROP SCHEMA geo CASCADE');
        \DB::statement('DROP SCHEMA dw CASCADE');
    }
}
