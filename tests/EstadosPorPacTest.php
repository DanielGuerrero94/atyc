<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EstadosPorPacTest extends TestCase
{
    public function testCurso()
    {
        $cursos = collect([]);
        for($j = 1; $j < 6; $j++) {
            for($i = 0; $i < 20; $i++) {
                $curso = new stdClass();
                $curso->id_estado = $j;
                $cursos->push($curso);
            }
        }

        $this->assertEquals($cursos->count(), 100);
        $estados = $this->estadosPorCursos($cursos);
        $this->assertEquals(count($estados), 6);
        $this->assertEquals($estados[1]['porcentaje'], 20);
    }

    public function estadosPorCursos($cursos)
    {
        $cantidad_cursos = $cursos->count();
        $repeticiones_estados = array(0, 0, 0, 0, 0, 0);
        $estados = array();
        $colores = ['warning', 'info', 'ejecutando', 'success', 'reprogramado', 'danger'];
        $titulos = ['Planificado', 'Diseñado', 'En ejecución', 'Reprogramado', 'Finalizado', 'Desactivado'];
        
        foreach ($cursos as $curso)
            $repeticiones_estados[$curso->id_estado-1]++;
        for($i = 0; $i < count($colores); $i++) {
            $estados[$i]['cantidad'] = $repeticiones_estados[$i];
            $estados[$i]['titulo'] = $titulos[$i];
            $estados[$i]['color'] = 'progress-bar-'.$colores[$i];
            $estados[$i]['porcentaje'] = ($repeticiones_estados[$i] / $cantidad_cursos) * 100;
        }
        return $estados;
    }

}
