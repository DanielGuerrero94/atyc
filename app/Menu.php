<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Menu extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'small';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_menu';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent','title','icon','order'];

    public function menus()
    {
        return $this->hasMany('App\Menu', 'parent', 'id_menu');
    }

    public function getOrderAttribute($order)
    {
        return (int) $order;
    }

    public function setParentAttribute($parent)
    {
        if (is_numeric($parent)) {
            $this->findOrFail($parent);   
        }
        $this->attributes['parent'] = $parent;
    }

    public function setOrderAttribute($order)
    {
        $this->guardsAgainstNonPositiveOrder($order);        
        $this->attributes['order'] = $order;
    }

    public function guardsAgainstNonPositiveOrder($order)
    {
        if ($order <= 0) {
            throw new Exception('Order must be a positive value.', 1);            
        }
    }

    public function addSubmenu($submenu)
    {
        $this->resolveOrder($submenu);
        $this->menus()->save($submenu);
        return $this;
    }

    public function removeSubmenu($submenu)
    {
        $submenu->parent = null;
        $submenu->save();
    }

    public function moveSubmenu($submenu, $order)
    {
        if ($submenu->order === $order) return;
        // $this->reorderDatabaseRecursive($submenu, $order);
        $this->reorderFunctional($submenu, $order);
        $submenu->order = $order;
        $submenu->save();
    }

    public function reorderDatabaseRecursive($submenu, $order)
    {
        $submenu = $this->where('parent', $submenu->parent)->where('order', $order)->first();
        if (!is_null($submenu)) {
            $this->moveSubmenu($submenu, $submenu->order + 1);
        }
    }

    public function reorderFunctional($submenu, $order)
    {
        $this->menus()
        ->where('order', '>=', $order)
        ->get()
        ->each(function ($menu)
        {
           $menu->order++;
           $menu->save(); 
        });
    }

    public function resolveOrder($submenu)
    {
        $max = $this->menus()->pluck('order')->max();
        $submenu->order = is_null($max)?$submenu->order:$max + 1;
        $submenu->save();
    }

}
