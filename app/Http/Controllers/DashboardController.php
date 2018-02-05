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

    public function firstDraw(Request $request)
    {
        return $this->counts($request);
    }

    public function counts(Request $request)
    {
        return [
            'participantes' => $this->getCountTable($request, "alumnos.alumnos"),
            'acciones' => $this->getCountTable($request, "cursos.cursos"),
            'docentes' => $this->getCountTable($request, "sistema.profesores")
        ];
    }

    public function pies()
    {
        return array(
            'porcentajeTematica' => $this->porcentajeTematica()
        );
    }

    public function areas(Request $request)
    {
        return [
            'accionesPorAnioYMes' => $this->accionesPorAnioYMes($request)
        ];
    }

    public function heats()
    {
        return array(
            'accionesReportadas' => $this->accionesInformadasEsteAnio()
        );
    }

    public function trees(Request $request)
    {
        return [
            'accionesPorTipologia' => $this->accionesPorTipologia($request),
            'accionesPorTematica' => $this->accionesPorTematica($request)
        ];
    }

    public function progress(Request $request)
    {
        return [
            'capacitados' => $this->mvCapacitados($request),
            'talleres' => $this->talleresSumarte($request)
            // 'efectores' => $this->efectores($request)
        ];
    }

    /**
     * El count despues tiene que ser por periodo y con mas join por las provincias
     */
    public function capacitados(Request $request)
    {
        $query = DB::table('efectores.efectores as e')
        ->select(DB::raw("count(distinct e.cuie)"))
        ->join('alumnos.alumnos as a', 'a.establecimiento1', '=', 'e.cuie')
        ->join('cursos.cursos_alumnos as ca', 'ca.id_alumno', '=', 'a.id_alumno')
        ->join('cursos.cursos as c', 'c.id_curso', '=', 'ca.id_curso')
        ->where('e.id_estado', 1);

        logger($request->get("anio"));
        if (($anio = $request->get('anio')) != 0) {
            logger($anio);
            $query = $query->where("c.fecha", ">", "{$anio}-01-01");
        }

        return $query->first()
        ->count;
    }

    public function mvCapacitados(Request $request)
    {
        $query = DB::table("efectores.mv_reporte_4");

        if (!is_numeric($anio = $request->get('anio'))) {
            $query = $query->selectRaw('sum(capacitados) as capacitados');
            $anio = date('Y');
        } elseif (!is_numeric($division = $request->get('division'))) {
            $query = $query->selectRaw('sum(capacitados) as capacitados');
        } else {
            $query = $query->select('capacitados');
        }

        $query = $query->whereRaw("desde = '{$anio}-01-01'")
        ->whereRaw("hasta = cast('".strval($anio + 1)."-01-01'::date - '1 day'::interval as date)");

        if (is_numeric($division = $request->get('division'))) {
            $query = $query->where('id_provincia', $division);
        }

        $capacitados = $query->first();

        return $capacitados?$capacitados->capacitados:0;
    }

    public function talleresSumarte(Request $request)
    {
        $query = Curso::whereRaw("nombre ~* 'sumarte'");

        if (is_numeric($anio = $request->get('anio'))) {
            $query = $query->whereYear('fecha', $anio);
        }

        if (is_numeric($division = $request->get('division'))) {
            $query = $query->where('id_provincia', $division);
        }

        return $query->count();
    }

    public function efectores(Request $request)
    {
        return DB::table('efectores.efectores as e')
        ->where('e.id_estado', 1)
        ->count();
    }

    private function getCountTable(Request $request, $table)
    {
        $query = DB::table($table)
        ->whereNull('deleted_at');

        if (is_numeric($anio = $request->get('anio'))) {
            $query = $query->whereYear('created_at', $anio);
        }

        if (is_numeric($division = $request->get('division'))) {
            /*
             * Los docentes no tienen provincia asociada todavia asi que los excluyo
             * de una manera bastante desprolija por ahora
             */
            if ($table != "sistema.profesores") {
                $query = $query->where('id_provincia', $division);
            }
        }

        return $query->count();
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

    private function accionesPorAnioYMes(Request $request)
    {
        $query = "(select extract(year from fecha) as anio,extract(month from fecha) as mes,
        count(*) as cantidad from cursos.cursos
        where fecha > '2013-01-01'";

        if (is_numeric($division = $request->get('division'))) {
            $query .= " and id_provincia = {$division}";
        }

        $query .= " group by extract(year from fecha),extract(month from fecha)
        order by extract(year from fecha),extract(month from fecha))
        union all
        (select max(extract(year from fecha))".
        ",generate_series((select extract(month from max(fecha))::numeric) + 1,12),0 from cursos.cursos)";

        $acciones = \DB::select($query);

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

    private function accionesPorTipologia(Request $request)
    {
        /*
         * Agrego una condicion obvia para que no se complique agregar los otros where
         * despues tengo que transformarla en query builder para que quede mas prolijo
         */
        $query = "select l.numero as tipo,l.nombre as titulo,count(*) as cantidad from cursos.cursos c 
        join cursos.lineas_estrategicas l on l.id_linea_estrategica = c.id_linea_estrategica
        where l.numero is not null";

        if (is_numeric($anio = $request->get('anio'))) {
            $query .= " and extract(year from c.fecha) = {$anio}";
        }

        if (is_numeric($division = $request->get('division'))) {
            $query .= " and c.id_provincia = {$division}";
        }

        $query .= " group by l.numero,l.nombre order by l.numero";

        $acciones = \DB::select($query);

        $contadorColores = 0;

        return collect($acciones)
        ->map(function ($accion) use (&$contadorColores) {
            $contadorColores++;
            return [
                'name' => $accion->tipo,
                'value' => $accion->cantidad,
                'colorValue' => $contadorColores,
                'label' => $accion->titulo
            ];
        })
        ->values()
        ->toArray();
    }

    private function accionesPorTematica(Request $request)
    {
        $query = "select a.nombre as tematica,count(*) as cantidad from cursos.cursos c 
        join cursos.areas_tematicas a on a.id_area_tematica = c.id_area_tematica
        where a.id_area_tematica is not null";

        if (is_numeric($anio = $request->get('anio'))) {
            $query .= " and extract(year from c.fecha) = {$anio}";
        }

        if (is_numeric($division = $request->get('division'))) {
            $query .= " and c.id_provincia = {$division}";
        }

        $query .= " group by a.nombre order by count(*) desc";

        $acciones = \DB::select($query);

        $contadorColores = 0;

        return collect($acciones)
        ->map(function ($accion) use (&$contadorColores) {
            $contadorColores++;
            return [
                'name' => $accion->tematica,
                'value' => $accion->cantidad,
                'colorValue' => $contadorColores
            ];
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
