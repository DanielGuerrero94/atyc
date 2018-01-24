<?php

namespace Tests;

use App\Http\Controllers\MaterialesController;
use App\Material;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

class MaterialesTest extends TestCase
{

	use WithoutMiddleware;
    use DatabaseTransactions;

    public function materialesProvider()
    {
        return [
            [
                'original' => 'test.csv',
                'path' => '/test/test',
                'id_etapa' => 5
            ]
        ];
    }

    /**
     * @test
     * @dataProvider materialesProvider
     */
    public function can_create($original, $path, $id_etapa)
    {
        $c = new MaterialesController();
        $id_material = Material::create(compact('original', 'path', 'id_etapa'))->id_material;
        $this->assertTrue(is_numeric($id_material), $id_material);
    }

	/**
	 * @test
     * @dataProvider materialesProvider
     */
    public function icon($original, $path, $id_etapa)
    {
        Material::create(compact('original', 'path', 'id_etapa'))->id_material;
        $c = new MaterialesController();
        $materiales = $c->generateList();
        $material = $materiales->first();
        $this->assertEquals('fa-lg fa-file-excel-o text-success', $material->icon);
    }

    /**
     * @test
     */
    public function unknown_icon_get_default()
    {
        $c = new MaterialesController();
        $id_etapa = 5;
        $original = 'test.unknown';
        $path = '/test/test';
        $id_material = Material::create(compact('original', 'path', 'id_etapa'))->id_material;
        $materiales = $c->generateList();
        $material = $materiales->where('id_material', $id_material)->first();
        $this->assertEquals('fa-lg fa-file-text-o', $material->icon);
    }

    /**
    * @test
    * @expectedException Illuminate\Database\QueryException
    */
    public function fail_same_name_in_same_step()
    {
        $id_etapa = 5;
        $original = 'test.unknown';
        $path = '/test/test';
        Material::create(compact('original', 'path', 'id_etapa'));
        $path = '/test/etapa/as';
        Material::create(compact('original', 'path', 'id_etapa'));
    }


    /**
     * @test
     * @expectedException Illuminate\Database\QueryException
     */
    public function path_must_be_unique()
    {
        $id_etapa = 5;
        $original = 'test.unknown';
        $path = '/test/test';
        Material::create(compact('original', 'path', 'id_etapa'));
        $id_etapa = 4;
        Material::create(compact('original', 'path', 'id_etapa'));
    }

    /**
     * @test
     */
    public function same_name_diff_step()
    {
        $id_etapa = 5;
        $original = 'test.unknown';
        $path = '/test/test';
        Material::create(compact('original', 'path', 'id_etapa'));
        $id_etapa = 4;
        $path = '/test/etapa/as';
        Material::create(compact('original', 'path', 'id_etapa'));
    }
}
