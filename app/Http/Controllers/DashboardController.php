<?php

namespace App\Http\Controllers;

use App\Models\Cursos\Curso;
use App\Models\Pac\FichaTecnica;
use App\Alumno;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

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
            'planificadas' => $this->accionesPlanificadas($request),
            'ejecutadas' => $this->accionesEjecutadas($request),
            'fichas_aprobadas' => $this->fichasAprobadas($request)
            // 'talleres' => $this->talleresSumarte($request)
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
            $query = $query->where("c.fecha_ejec_inicial", ">", "{$anio}-01-01");
        }

        return $query->first()
        ->count;
    }

    public function mvCapacitados(Request $request)
    {
        $query = DB::table("efectores.mv_reporte_4");

        if (!is_numeric($anio = $request->get('anio'))) {
            $query = $query->selectRaw('sum(capacitados) as capacitados');
        } elseif (!is_numeric($division = $request->get('division'))) {
            $query = $query->selectRaw('sum(capacitados) as capacitados');
        } else {
            $query = $query->select('capacitados');
        }
    
        if (!is_numeric($anio)) {
            $anio = date('Y');
            $query = $query->whereRaw("desde = '2013-01-01'");
        } else {
            $query = $query->whereRaw("desde = '{$anio}-01-01'");
        }

        $query = $query->whereRaw("hasta = cast('".strval($anio + 1)."-01-01'::date - '1 day'::interval as date)");

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
            $query = $query->whereYear('fecha_ejec_inicial', $anio);
        }

        if (is_numeric($division = $request->get('division'))) {
            $query = $query->where('id_provincia', $division);
        }

        return $query->count();
    }

    public function accionesPlanificadas(Request $request)
    {
        $anio = $request->get('anio');
        $division = $request->get('division');

        logger("anio: ".$anio);
        logger("division: ".$division);

        $query = DB::table('cursos.cursos');

        if(is_numeric($anio)) {
            $query = $query->where(function($q) use ($anio) {
                $q->orWhereBetween('fecha_plan_inicial', [$anio.'-01-01',$anio.'-12-31'])
                ->orWhereBetween('fecha_plan_final', [$anio.'-01-01',$anio.'-12-31'])
                ->orWhereBetween('fecha_ejec_inicial', [$anio.'-01-01',$anio.'-12-31'])
                ->orWhereBetween('fecha_ejec_final', [$anio.'-01-01',$anio.'-12-31']);
            });
        }

        if(is_numeric($division)) {
            $query = $query->where('id_provincia', $division);
        }
        
        logger(json_encode($query->count()));
        return $query->count();
    }

    public function accionesEjecutadas(Request $request)
    {
        $anio = $request->get('anio');
        $division = $request->get('division');

        $query = Curso::whereIn('id_estado', [3, 4]);

        if(is_numeric($anio)) {
            $query = $query->where(function($q) use ($anio) {
                $q->orWhereBetween('fecha_plan_inicial', [$anio.'-01-01',$anio.'-12-31'])
                ->orWhereBetween('fecha_plan_final', [$anio.'-01-01',$anio.'-12-31'])
                ->orWhereBetween('fecha_ejec_inicial', [$anio.'-01-01',$anio.'-12-31'])
                ->orWhereBetween('fecha_ejec_final', [$anio.'-01-01',$anio.'-12-31']);
            });
        }

        if(is_numeric($division)) {
            $query = $query->where('id_provincia', $division);
        }

        return $query->count();
    }

    public function fichasAprobadas(Request $request)
    {
        $anio = $request->get('anio');
        $division = $request->get('division');

        $query = FichaTecnica::where('aprobada', true);

        if(is_numeric($anio)) {
            $query = $query->join('pac.pacs', 'id_pac','=','pacs.id_pac')
            ->where('pacs.anio', $anio);
        }

        if(is_numeric($division)) {
            $query = $query->join('pac.pacs', 'id_pac','=','pacs.id_pac')
            ->where('pacs.id_provincia', $division);
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
        $query = "(select extract(year from fecha_ejec_inicial) as anio,extract(month from fecha_ejec_inicial) as mes,
        count(*) as cantidad from cursos.cursos
        where fecha_ejec_inicial > '2013-01-01'";

        if (is_numeric($division = $request->get('division'))) {
            $query .= " and id_provincia = {$division}";
        }

        $query .= " group by extract(year from fecha_ejec_inicial),extract(month from fecha_ejec_inicial)
        order by extract(year from fecha_ejec_inicial),extract(month from fecha_ejec_inicial))
        union all
        (select max(extract(year from fecha_ejec_inicial))".
        ",generate_series((select extract(month from max(fecha_ejec_inicial))::numeric) + 1,12),0 from cursos.cursos)";

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
            $query .= " and extract(year from c.fecha_ejec_inicial) = {$anio}";
        }

        if (is_numeric($division = $request->get('division'))) {
            $query .= " and c.id_provincia = {$division}";
        }

        $query .= " group by l.numero,l.nombre order by l.numero";

        $acciones = \DB::select($query);

        return collect($acciones)
        ->map(function ($accion) {
            return [
                'name' => $accion->tipo,
                'value' => $accion->cantidad,
                'colorValue' => $accion->cantidad,
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
            $query .= " and extract(year from c.fecha_ejec_inicial) = {$anio}";
        }

        if (is_numeric($division = $request->get('division'))) {
            $query .= " and c.id_provincia = {$division}";
        }

        $query .= " group by a.nombre order by count(*) desc";

        $acciones = \DB::select($query);


        return collect($acciones)
        ->map(function ($accion) {
            return [
                'name' => $accion->tematica,
                'value' => $accion->cantidad,
                'colorValue' => $accion->cantidad
            ];
        })
        ->values()
        ->toArray();
    }

    private function accionesInformadasEsteAnio()
    {
        $acciones = \DB::select("(select id_provincia,extract(month from fecha_ejec_inicial) as mes,
            count(*) as cantidad from cursos.cursos 
            where extract(year from fecha_ejec_inicial) = extract(year from now())
            and id_provincia <> 25
            group by id_provincia,extract(month from fecha_ejec_inicial)
            order by id_provincia,extract(month from fecha_ejec_inicial))
            union all
            (select distinct id_provincia,
                generate_series(
                    (select extract(month from max(c.fecha_ejec_inicial)) + 1 from cursos.cursos c
                    where extract(year from c.fecha_ejec_inicial) = extract(year from now())
                    and c.id_provincia = ca.id_provincia)::numeric,12),0
                    from cursos.cursos ca
                    where extract(year from fecha_ejec_inicial) = extract(year from now())
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

    public function getHistorial(Request $request)
    {
        $now = (new Carbon)->today();
        $antiguedad = $now->subDays($request->input('periodo', 30))->toDateTimeString();
        //Por ahora busca el historial de una semana por default

        if ($request->input('categoria', 'acciones') == 'acciones') {
            $acciones = Curso::select('id_provincia', 'id_curso', 'nombre', 'created_at', 'fecha_ejec_inicial', 'edicion')
            ->with('provincia')
            ->whereDate('created_at', '>', $antiguedad)
            ->orderBy('created_at', 'desc')
            ->orderBy('id_provincia');

            if ($request->has('provincia')) {
                $acciones = $acciones->where('id_provincia', $request->id_provincia);
            }
            
            $acciones = $acciones->get();
        }

        if ($request->input('categoria', 'participantes') == 'participantes') {    
            $participantes = Alumno::select('id_provincia', 'id_alumno', 'nombres', 'apellidos', 'created_at')
            ->with('provincia')
            ->whereDate('created_at', '>', $antiguedad)
            ->orderBy('created_at', 'desc')
            ->orderBy('id_provincia');

            if ($request->has('provincia')) {
                $participantes = $participantes->where('id_provincia', $request->id_provincia);
            }   

            $participantes = $participantes->get();
        }

        /* 
           Tengo que agregar el id provincia a los docentes haciendo un update en base a la primer accion en la que estuvieron
           $docentes = Profesor::select('id_provincia', 'id_profesor', 'nombre', 'created_at')
           ->with('provincia')
           ->whereDate('created_at', '>', $last_week)
           ->orderBy('created_at', 'desc')
           ->get();
         */

        return view('notificaciones.historial', compact('acciones', 'participantes'));
    }

    public function getHistorialCompleto()
    {
        return view('ideas.historial-completo');
    }
}
