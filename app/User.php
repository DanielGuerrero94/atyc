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
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'id_provincia',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot'
    ];

    public function provincia()
    {
        return $this->hasOne('App\Provincia', 'id_provincia', 'id_provincia');
    }

    public function roles()
    {
        return $this->belongsToMany(
            'App\Role',
            'public.users_roles',
            'id_user',
            'id_role'
        )->withTimestamps();
    }

    public function isUEC()
    {
        return $this->id_provincia == 25;
    }

    public function isAdmin()
    {
        return $this->roles->contains('id_role', 2);
    }

    public function tieneRol($role) {
        $user = Auth::user();
        return $this->whereHas('roles', function ($query) use ($role) 
        {
            $query->where('name', $role);
        })
        ->where('id_user', $user->id_user)
        ->count() > 0;
    }

    public function darDeAlta() {
        $this->deleted_at = null;
        $this->save();
    }
}
