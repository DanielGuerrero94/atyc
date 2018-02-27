<?php

use Illuminate\Database\Seeder;

class UpdateFixesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->updateAreasTematicas();
        // $this->updateLineasEstrategicas();
        // $this->updateAcciones();
        // $this->updateParticipantes();
        // $this->updateDocentes();
        $this->updateCursosAreasTematicas();
    }

    public function updateAreasTematicas()
    {
        \App\Models\Cursos\AreaTematica::get()
        ->each(function ($model) {
            $model->setUpdatedAt('2013-01-01')->setCreatedAt('2013-01-01')->save();
        });
    }

    public function updateLineasEstrategicas()
    {
        \App\Models\Cursos\LineaEstrategica::get()
        ->each(function ($model) {
            $model->setUpdatedAt('2013-01-01')->setCreatedAt('2013-01-01')->save();
        });
    }

    public function updateParticipantes()
    {
        # code...
    }

    public function updateCursosAreasTematicas()
    {
        \App\Models\Cursos\Curso::get()
        ->each(function ($model) {
            $model->areasTematicas()->attach($model->id_area_tematica);
        });
    }
}
