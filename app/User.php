<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
 use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'id_provincia', 'title'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function provincia()
    {
        return $this->hasOne('App\Provincia', 'id_provincia', 'id_provincia');
    }

    /**
     * Relacion de multiples roles de los usuarios 
     *
     */
    public function roles()
    {
        return $this->belongsToMany(
            'App\Role',
            'public.users_roles',
            'id_role',
            'id_user'
        )
            ->withTimestamps();
    }

    public function isUEC()
    {
        return $this->id_provincia == 25;
    }

    public function tieneRol(string $role)
    {
        return $this->whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->count() > 0;
    }

    public function darDeAlta()
    {
        $this->deleted_at = null;
        $this->save();
    }
}
