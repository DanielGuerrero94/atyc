<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursos\Curso;
use DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }

    public function registrar()
    {
        return view('registrar');
    }

    public function entrar()
    {
        return view('entrar');
    }

    public function firstDraw()
    {
        return $this->counts();
    }

    public function counts()
    {
        return array(
            'participantes' => $this->getCountTable("alumnos.alumnos"),
            'acciones' => $this->getCountTable("cursos.cursos"),
            'docentes' => $this->getCountTable("sistema.profesores")
        );
    }

    public function pies()
    {
        return array(
            'porcentajeTematica' => $this->porcentajeTematica()
        );
    }

    public function areas()
    {
        return array(
            'accionesPorAnioYMes' => $this->accionesPorAnioYMes()
        );
    }

    public function heats()
    {
        return array(
            'accionesReportadas' => $this->accionesInformadasEsteAnio()
        );
    }

    public function trees()
    {
        return array(
            'accionesPorTipologia' => $this->accionesPorTipologia(),
            'accionesPorTematica' => $this->accionesPorTematica()
        );
    }

    public function progress()
    {
        return [
            'capacitados' => $this->capacitados(),
            'efectores' => $this->efectores(),
        ];
    }

    /**
     * El count despues tiene que ser por periodo y con mas join por las provincias
     */
    public function capacitados()
    {
        return DB::table('efectores.efectores as e')
        ->join('alumnos.alumnos as a', 'a.establecimiento1', '=', 'e.cuie')
        ->join('cursos.cursos_alumnos as ca', 'ca.id_alumno', '=', 'a.id_alumno')
        ->join('cursos.cursos as c', 'c.id_curso', '=', 'ca.id_curso')
        ->groupBy('e.cuie')
        ->count();
    }

    public function efectores()
    {
        return DB::table('efectores.efectores as e')
        ->where('e.id_estado', 1)
        ->count();
    }

    private function getCountTable($table)
    {
        return DB::table($table)
        ->whereNull('deleted_at')
        ->count();
    }

    private function porcentajeTematica()
    {
        $cursos = Curso::query()
        ->join(
            'cursos.lineas_estrategicas',
            'cursos.id_linea_estrategica',
            '=',
            'cursos.lineas_estrategicas.id_linea_estrategica'
        )
        ->select(
            DB::raw('CONCAT(cursos.lineas_estrategicas.numero,
                \' - \',cursos.lineas_estrategicas.nombre) as label'),
            DB::raw('count(*) as value')
        )
        ->groupBy('cursos.lineas_estrategicas.nombre', 'cursos.lineas_estrategicas.numero')
        ->get();
        
        $total = $cursos->reduce(
            function ($carry, $value) {
                return $carry + $value->value;
            }
        );

        $data = array();

        $cursos->each(
            function ($value, $item) use ($total, &$data) {
                $array = array('name' => $value->label,'y' => round($value->value * 100 / $total, 2));
                array_push($data, $array);
            }
        );

        return array(
            array(
                'name' => 'Lineas',
                'data' => $data
            )
        );
    }

    private function accionesPorAnioYMes()
    {
        $acciones = \DB::select("(select extract(year from fecha) as anio,extract(month from fecha) as mes,
            count(*) as cantidad from cursos.cursos
            where fecha > '2013-01-01'
            group by extract(year from fecha),extract(month from fecha)
            order by extract(year from fecha),extract(month from fecha))
            union all
            (select max(extract(year from fecha)),generate_series(
                (select extract(month from max(fecha))::numeric) + 1,12),0 from cursos.cursos)");

        $colores = ['#d0d1e6','#a6bddb','#67a9cf','#3690c0','#02818a','#016c59','#014636'];

        return collect($acciones)
        ->groupBy('anio')
        ->map(function ($acciones, $anio) use (&$colores) {
            return array(
                'name' => $anio,
                'data' => array_map(function ($dato) {
                    return $dato->cantidad;
                }, $acciones->toArray()),
                'color' => array_shift($colores)
            );
        })
        ->values()
        ->toArray();
    }

    private function accionesPorTipologia()
    {
        $acciones = \DB::select("select l.numero as tipo,l.nombre as titulo,count(*) as cantidad from cursos.cursos c 
            join cursos.lineas_estrategicas l on l.id_linea_estrategica = c.id_linea_estrategica
            group by l.numero,l.nombre
            order by l.numero");

        $contadorColores = 0;

        return collect($acciones)
        ->map(function ($accion) use (&$contadorColores) {
            $contadorColores++;
            return array(
                'name' => $accion->tipo,
                'value' => $accion->cantidad,
                'colorValue' => $contadorColores,
                'label' => $accion->titulo
            );
        })
        ->values()
        ->toArray();
    }

    private function accionesPorTematica()
    {
        $acciones = \DB::select("select a.nombre as tematica,count(*) as cantidad from cursos.cursos c 
            join cursos.areas_tematicas a on a.id_area_tematica = c.id_area_tematica
            group by a.nombre
            order by count(*) desc");

        $contadorColores = 0;

        return collect($acciones)
        ->map(function ($accion) use (&$contadorColores) {
            $contadorColores++;
            return array(
                'name' => $accion->tematica,
                'value' => $accion->cantidad,
                'colorValue' => $contadorColores
            );
        })
        ->values()
        ->toArray();
    }

    private function accionesInformadasEsteAnio()
    {
        $acciones = \DB::select("(select id_provincia,extract(month from fecha) as mes,
            count(*) as cantidad from cursos.cursos 
            where extract(year from fecha) = extract(year from now())
            and id_provincia <> 25
            group by id_provincia,extract(month from fecha)
            order by id_provincia,extract(month from fecha))
            union all
            (select distinct id_provincia,
                generate_series(
                    (select extract(month from max(c.fecha)) + 1 from cursos.cursos c
                    where extract(year from c.fecha) = extract(year from now())
                    and c.id_provincia = ca.id_provincia)::numeric,12),0
                    from cursos.cursos ca
                    where extract(year from fecha) = extract(year from now())
                    and id_provincia <> 25
                )");

        return collect($acciones)
        ->map(function ($accion) {
            return array(
                '0' => intval($accion->mes) - 1,
                '1' => $accion->id_provincia - 1,
                '2' => $accion->cantidad,
            );
        })->toArray();
    }
}
