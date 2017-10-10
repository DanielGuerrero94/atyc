<?php

use Illuminate\Database\Seeder;

class FakerSeeder extends Seeder
{
    public function run()
    {
        factory(App\User::class, 3)->create();
        factory(App\TipoDocumento::class, 6)->create();
        factory(App\Pais::class, 30)->create();
        factory(App\Provincia::class, 25)->create();
        factory(App\Trabajo::class, 10)->create();
        factory(App\Funcion::class, 10)->create();
        factory(App\Convenio::class, 10)->create();
        factory(App\Models\Cursos\LineaEstrategica::class, 30)->create();
        factory(App\Models\Cursos\AreaTematica::class, 30)->create();
        factory(App\Alumno::class, 30)->create();
        factory(App\Profesor::class, 30)->create();
        factory(App\Models\Cursos\Curso::class, 10)->create();
        
        DB::insert("
		insert into menus (id_padre, title, icon, orden) 
		values (1, 'Gestionar', 'arrow-left', 0),
		(1, 'Acciones', 'circle-o', 0),
		(1, 'Participantes', 'circle-o', 1),
		(1, 'Equipo Docente', 'circle-o', 2),
		(5, 'ABM', 'arrow-left', 0),
		(5, 'TipoAccion', 'circle-o', 0),
		(5, 'Tematica', 'circle-o', 1),
		(5, 'ParticipantesRol', 'circle-o', 2),
		(5, 'DocentesRol', 'circle-o', 3),
		");

        $roles = [
            ['name' => 'SUPERADMIN'],
            ['name' => 'ADMIN'],
            ['name' => 'UEC'],
            ['name' => 'UGSP'],
            ['name' => 'PARTICIPANTE'],
            ['name' => 'DOCENTE']
        ];

        foreach ($roles as $role) {
            App\Role::create($role);
        }
    }
}
