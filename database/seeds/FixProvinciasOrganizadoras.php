<?php

use Illuminate\Database\Seeder;

class FixProvinciasOrganizadoras extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Por default la organizadora va ser la ugsp
        //El otro caso que puedo resolver es todos los que tengan el tipo taller sumarte en el nombre sea UEC Atyc
        /*
        \DB::statement("UPDATE cursos.cursos set organizadora = id_provincia;");
*/
        $talleres = \DB::select("select * from cursos.cursos where tipo_")

        if ($roles == 0) {
            $this->call('RolesTableSeeder');
        }
       
        $users = \App\User::all()->each(function ($user) {
            $user->roles()->attach(['1']);
        });

    }
    
}
