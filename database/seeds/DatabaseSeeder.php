<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Corre los seeders en orden.
     *
     * @return void
     */
    public function run()
    {
        //Schema sistema
        $this->call(PaisesTableSeeder::class);
        $this->call(PeriodosTableSeeder::class);
        $this->call(TiposDocumentosTableSeeder::class);
        $this->call(ProvinciasTableSeeder::class);
        $this->call(ProfesoresTableSeeder::class);
        $this->call(ReportesTableSeeder::class);

    	//Schema public
        $this->call(UsersTableSeeder::class);
        
        //Schema alumnos
        $this->call(TrabajosTableSeeder::class);
        $this->call(ConveniosTableSeeder::class);
        $this->call(FuncionesTableSeeder::class);
        $this->call(AlumnosTableSeeder::class);

        //Schema cursos
        $this->call(AreasTematicasTableSeeder::class);
        $this->call(LineasEstrategicasTableSeeder::class);
        $this->call(CursosTableSeeder::class);
        $this->call(CursosAlumnosTableSeeder::class);
        $this->call(CursosProfesoresTableSeeder::class);

        //Schema encuestas
        $this->call(PreguntasTableSeeder::class);
        $this->call(RespuestasTableSeeder::class);
        $this->call(EncuestasTableSeeder::class);
    }
}
