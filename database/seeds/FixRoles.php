<?php

use Illuminate\Database\Seeder;

class FixRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //If the roles are inserted and user has not yet default role makes update 
        $roles = \DB::table('public.roles')->count();

        if ($roles == 0) {
            $this->call('RolesTableSeeder');
        }
       
        $users = \App\User::all()->each(function ($user) {
            $user->roles()->attach(['1']);
        });

    }
    
}
