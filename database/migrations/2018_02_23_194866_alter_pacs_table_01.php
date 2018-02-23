<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPacsTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pac.pac', function (Blueprint $table) {
            $table->boolean('t1')->default('false');
            $table->boolean('t2')->default('false');
            $table->boolean('t3')->default('false');
            $table->boolean('t4')->default('false');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pac.pac', function (Blueprint $table) {
            $table->dropColumn('t1');
            $table->dropColumn('t2');
            $table->dropColumn('t3');
            $table->dropColumn('t4');
        });
    }
}
