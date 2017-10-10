<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function provincia()
    {
        return $this->hasOne('App\Provincia', 'id', 'id_provincia');
    }

    public function roles()
    {
        return $this->belongsToMany(
            'App\Role',
            'public.roles',
            'id_user',
            'id_role'
        )
            ->withTimestamps();
    }
}
