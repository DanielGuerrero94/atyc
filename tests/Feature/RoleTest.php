<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Factories\Role;

class RoleTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		Role::truncate();
	}

	/** @test */
	public function a_role_can_be_created()
	{
		$role = Role::create(['name' => 'Admin']);
		$this->assertEquals(1, $role->id_role);
	}

	/** 
	 * @test
	 * @expectedException AsException
	 */
	public function a_role_name_must_be_unique()
	{
		$role1 = Role::create(['name' => 'Admin']);
		$role2 = Role::create(['name' => 'Admin']);
		$this->assertEquals(1, $role->id_role);
	}
    
    public function dxample()
    {
    	$menus = factory('App\Menu::class', 2)->create();;
    	$submenus = factory('Database\Factories\Submenu::class', 4)->create();

        $this->assertTrue(true);
    }
}
