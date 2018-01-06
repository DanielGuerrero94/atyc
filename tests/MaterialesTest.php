<?php

namespace Tests;

use App\Http\Controllers\MaterialesController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class MaterialesTest extends TestCase
{

	use WithoutMiddleware;

	/**
	 * @test
     */
    public function icon()
    {
    	$c = new MaterialesController();
    	$materiales = $c->generateList();
    	$material = $materiales->first();
        $this->assertEquals('fa-file-excel-o', $material->icon);
    }
}
