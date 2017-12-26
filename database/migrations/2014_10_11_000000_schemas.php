<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class Schemas extends Migration
{

    protected $schemas = ['alumnos', 'cursos', 'encuestas', 'pac', 'sistema', 'beneficiarios', 'efectores', 'geo',
    'dw'];

    /**
     * Run the migrations.
     * Por ser distinta la creacion de postgres al
     * involucrar extensiones por dblink
     * esta migracion es la unica que diferencia
     *
     * @return void
     */
    public function up()
    {

        if (env('DB_CONNECTION') === "pgsql") {
            DB::statement('CREATE EXTENSION IF NOT EXISTS dblink');
            DB::statement('CREATE EXTENSION IF NOT EXISTS postgres_fdw');
            foreach ($this->schemas as $schema) {
                DB::statement('CREATE SCHEMA IF NOT EXISTS '.$schema);
            }
        }

        /*SQLITE*/
        if (env('DB_CONNECTION') === "testing") {

            foreach ($this->schemas as $schema) {
                $path = database_path($schema.'.sqlite');
                system('touch '.$path);
                DB::statement('attach database "'.$path.'" as '.$schema);
            }
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (env('DB_CONNECTION') === "pgsql") {
            DB::statement('DROP SCHEMA alumnos CASCADE');
            DB::statement('DROP SCHEMA cursos CASCADE');
            DB::statement('DROP SCHEMA encuestas CASCADE');
            DB::statement('DROP SCHEMA pac CASCADE');
            DB::statement('DROP SCHEMA sistema CASCADE');
            DB::statement('DROP SCHEMA beneficiarios CASCADE');
            DB::statement('DROP SCHEMA efectores CASCADE');
            DB::statement('DROP SCHEMA geo CASCADE');
            DB::statement('DROP SCHEMA dw CASCADE');
        }

        /*SQLITE*/
        if (env('DB_CONNECTION') === "testing") {

            foreach ($this->schemas as $schema) {
                $path = database_path($schema.'.sqlite');
                system('rm '.$path);
            }
        }
    }
}
