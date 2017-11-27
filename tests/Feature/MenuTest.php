<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Menu;
use Exception;

class MenuTest extends TestCase
{
	/**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown()
    {
    	parent::tearDown();
    	Menu::truncate();
    }

    /** @test */
    public function a_menus_parent_has_to_exists()
    {
    	$this->expectException(Exception::class);
    	Menu::make(['title' => 'First', 'icon' => 'search', 'order' => 1, 'parent' => 1]);
    }

    /** @test */
    public function a_menus_parent_can_be_null()
    {
    	$menu = Menu::create(['title' => 'First', 'icon' => 'search', 'order' => 1]);
    	$this->assertTrue(is_numeric($menu->id_menu));
    }

	/** @test */
    public function zero_or_negative_orders_must_fail()
    {
    	$this->expectException(Exception::class);
    	Menu::make(['title' => 'First', 'icon' => 'search', 'order' => -1]);
    }

    /** @test */
    public function positive_order_can_be_assign()
    {
    	$menu = Menu::create(['title' => 'First', 'icon' => 'search', 'order' => 1]);
    	$this->assertTrue(is_numeric($menu->id_menu));
    }

    private function completeMenuProvider()
    {
    	$menu = Menu::create(['title' => '1', 'icon' => 'search', 'order' => 1]);
    	$submenu = Menu::create(['title' => 'a', 'icon' => 'edit', 'order' => 1]);
    	$menu->addSubmenu($submenu);
    	return $menu;
    }

    /** @test */
    public function can_add_submenu()
    {
    	$menu = $this->completeMenuProvider();
    	$this->assertCount(1, $menu->menus()->get());
    }

    /** @test */
    public function submenu_does_not_count_as_top_level_menu()
    {
    	$menu = $this->completeMenuProvider();
    	$countTopLevelMenus = Menu::whereNull('parent')->count();
    	$this->assertEquals(1, $countTopLevelMenus);
    }

    /** @test */
    public function can_remove_submenu()
    {
    	$menu = $this->completeMenuProvider();
    	$submenu = $menu->menus()->first();
    	$menu->removeSubmenu($submenu);
    	$this->assertCount(0, $menu->menus()->get());
    }

    /** @test */
    public function can_change_submenu_order()
    {
    	$menu = $this->completeMenuProvider();
    	$submenu = $menu->menus()->first();
    	$menu->moveSubmenu($submenu, 2);
    	$this->assertEquals(2, $menu->menus()->first()->order);
    }

    /** @test */
    public function resolution_for_single_order_overlaping_adding_submenu()
    {
    	$menu = $this->completeMenuProvider();
    	// Issue with cross test factory calls
    	// $anotherSubmenu = factory(Menu::class)->create(['order' => 1]);
    	$anotherSubmenu = Menu::create(['title' => '1', 'icon' => 'search', 'order' => 1]);
    	$menu->addSubmenu($anotherSubmenu);
    	list($a, $b) = $menu->menus()->get();
    	$this->assertFalse($a->order === $b->order);
    }

    /** @test */
    public function resolution_for_multiple_order_overlaping_adding_submenu()
    {
    	$menu = $this->completeMenuProvider();
    	$submenu2 = factory(Menu::class)->create(['order' => 2]);
    	$menu->addSubmenu($submenu2);
    	$submenu3 = factory(Menu::class)->create(['order' => 1]);
    	$menu->addSubmenu($submenu3);
    	list($a, $b, $c) = $menu->menus()->get();
    	$this->assertEquals(3, $c->order);
    }

    /** @test */
    public function reorder_submenus_after_a_submenu_change_his_order()
    {
    	$menu = $this->completeMenuProvider();
    	$b = Menu::create(['title' => 'b', 'icon' => 'search', 'order' => 2]);
    	$c = Menu::create(['title' => 'c', 'icon' => 'search', 'order' => 3]);
    	$menu->addSubmenu($b)
    	->addSubmenu($c)
    	->moveSubmenu($c, 1);
    	$menus = $menu->menus()->orderBy('order')->pluck('title')->toArray();
    	$this->assertEquals(['c','a','b'], $menus);
    }
}
