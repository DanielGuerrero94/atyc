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
        $c = new ReportesController();
        $id_reporte = '6';
        $id_provincia = 15;
        $desde = '2017-06-01';
        $hasta = '2017-06-15';
        $request = new Request(['id_reporte' => '6', 'filtros' => compact('id_provincia', 'desde', 'hasta')]);
        $data = $c->queryLogica($request);
        // $data = DB::select($data);
        $data = $data->get();
        $this->assertEquals(42, count($data));
        $data = $data->map(function ($value) use ($desde, $hasta) {
            $value->periodo = "{$desde}/{$hasta}";
            return $value;
        });
        $data = json_encode($data);
        // $this->assertNull($data);
        // $this->assertEquals('4305f043bfbca156d02bafffe1194d2c', hash('md5', $data));
        $this->assertEquals('d93a8546bd86606ede7bb084b5717fa5', hash('md5', $data));
    }
}
