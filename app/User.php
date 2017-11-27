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

      public function menus() 
      { 
        return [ 
            'menus' => [ 
                [ 
                    'url' => '/alumnos', 
                    'icon' => 'fa fa-user-o', 
                    'title' => 'Gestión de Participantes' 
                ], 
                [ 
                    'url' => '/profesores', 
                    'icon' => 'fa fa-graduation-cap', 
                    'title' => 'Gestión de Docentes' 
                ], 
                [ 
                    'url' => '/cursos', 
                    'icon' => 'fa fa-address-book', 
                    'title' => 'Gestión de Acciones' 
                ], 
            ], 
            'abm_menus' => [ 
                [ 
                    'url' => '/areasTematicas', 
                    'icon' => 'fa fa-circle-o', 
                    'title' => 'Areas temáticas' 
                ], 
                [ 
                    'url' => '/periodos', 
                    'icon' => 'fa fa-circle-o', 
                    'title' => 'Periodos' 
                ], 
                [ 
                    'url' => '/lineasEstrategicas', 
                    'icon' => 'fa fa-circle-o', 
                    'title' => 'Tipologias de acción' 
                ], 
                [ 
                    'url' => '/tipoDocentes', 
                    'icon' => 'fa fa-circle-o', 
                    'title' => 'Tipo de docentes' 
                ], 
                [ 
                    'url' => '/funciones', 
                    'icon' => 'fa fa-circle-o', 
                    'title' => 'Rol en el sumar' 
                ], 
            ], 
        ]; 
    }     
}
