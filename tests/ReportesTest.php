<?php

namespace Tests;

use App\Http\Controllers\ReportesController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
    	$_ENV['DB_DATABASE'] = 'atyc';
    	$c = new ReportesController();
    	$request = new Request(['id_reporte' => '6', 'filtros' => ['id_provincia' => 15, 'desde' => '2017-06-01', 'hasta' => '2017-06-15']]);
    	$data = $c->queryLogica($request);
    	$data = DB::select($data);
    	$this->assertEquals(42, count($data));
    	$data = json_encode($data);
        // $this->assertNull($data);
        $this->assertEquals('4305f043bfbca156d02bafffe1194d2c', hash('md5', $data));
        $_ENV['DB_DATABASE'] = 'atyc_testing';
    }
}
