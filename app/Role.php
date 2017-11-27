<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_role';

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
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(
            'App\User',
            'public.users',
            'id_role',
            'id_user'
        )
            ->withTimestamps();
    }

    public function menus()
    {
        return $this->hasMany('App\Menu', 'id_menu', 'id_role');
    }
}
