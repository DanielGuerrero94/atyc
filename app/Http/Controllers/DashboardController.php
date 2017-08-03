<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursos\Curso;
use DB;

class DashboardController extends Controller
{
    private $nombre_mes  = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

    //Para ahorrarme escribir siempre que connection usar
    public function query($query)
    {
        return DB::connection('eLearning')->select($query);
    }

    public function get()
    {

        $counts = array(
         'alumnos' => $this->getCountAlumnos(),
         'cursos' => $this->getCountCursos(),
         'profesores' => $this->getCountProfesores());

        $tortas = array(
         'cursos_areas_tematicas' => $this->getCountCursosPorAreaTematica(),
         'cursos_lineas_estrategicas' => $this->getCountCursosPorLineaEstrategica(),
         'cursos_lineas_estrategicas_hc' => $this->to_highchart_pie(),
         'cursos_por_provincia' => $this->getCountCursosPorProvincia());

        $graficos = array(
         'cursos2013' => $this->getCursosPorAnioYMes('2013'),
         'cursos2014' => $this->getCursosPorAnioYMes('2014'),
         'cursos2015' => $this->getCursosPorAnioYMes('2015'),
         'cursos2016' => $this->getCursosPorAnioYMes('2016'),
         'cursos_por_anio' => $this->getCursosPorAnio(),
         'cursos_por_anio_hc' => $this->getCursosPorAnioHc(),
         'cursos_por_anio_y_mes_hc' => $this->getCursosPorAnioYMesHc(),
         'accionesAnioMes' => $this->accionesAnioMes());


        $returns = array_merge($counts, $tortas);
        $returns = array_merge($returns, $graficos);
        return json_encode($returns);
    }

    private function getCountTabla($tabla)
    {
        return DB::table($tabla)
        ->whereNull('deleted_at')
        ->get();
    }

    private function getCountAlumnos()
    {
        return $this->getCountTabla("alumnos.alumnos")->count();
    }

    private function getCountCursos()
    {
        return $this->getCountTabla("cursos.cursos")
            ->groupBy('nombre')
            ->count();
    }

    private function getCountProfesores()
    {
        return $this->getCountTabla("sistema.profesores")->count();
    }

    private function getCursos()
    {
        return Curso::query();
    }

    private function getCountCursosPorAreaTematica()
    {
        return $this->getCursos()
            ->join('cursos.areas_tematicas', 'cursos.cursos.id_area_tematica', '=', 'cursos.areas_tematicas.id_area_tematica')
            ->select('cursos.areas_tematicas.nombre as label', DB::raw('count(*) as value'))
            ->groupBy('cursos.areas_tematicas.nombre')
            ->get();
    }

    private function getCountCursosPorLineaEstrategica()
    {
        return $this->getCursos()
            ->join('cursos.lineas_estrategicas', 'cursos.id_linea_estrategica', '=', 'cursos.lineas_estrategicas.id_linea_estrategica')
            ->select(DB::raw('CONCAT(cursos.lineas_estrategicas.numero,\' - \',cursos.lineas_estrategicas.nombre) as label'), DB::raw('count(*) as value'))
            ->groupBy('cursos.lineas_estrategicas.nombre', 'cursos.lineas_estrategicas.numero')
            ->get();
    }

    private function getCursosPorAnioYMes($anio)
    {
        return $this->getCursos()
            ->select(DB::raw('count(*) as cantidad,EXTRACT(ISOYEAR FROM cursos.cursos.fecha) as anio,EXTRACT(MONTH FROM cursos.cursos.fecha) as mes'))
            ->whereYear('cursos.cursos.fecha', $anio)
            ->groupBy(DB::raw('EXTRACT(ISOYEAR FROM cursos.cursos.fecha),EXTRACT(MONTH FROM cursos.cursos.fecha)'))
            ->orderBy(DB::raw('EXTRACT(ISOYEAR FROM cursos.cursos.fecha),EXTRACT(MONTH FROM cursos.cursos.fecha)'))
            ->get();
    }

    private function getCursosPorAnio()
    {
        return $this->getCursos()
            ->select(DB::raw('count(*) as cantidad,EXTRACT(ISOYEAR FROM cursos.cursos.fecha) as anio'))
            ->where(DB::raw('EXTRACT(ISOYEAR FROM cursos.cursos.fecha)'), '>=', '2013')
            ->groupBy(DB::raw('EXTRACT(ISOYEAR FROM cursos.cursos.fecha)'))
            ->orderBy(DB::raw('EXTRACT(ISOYEAR FROM cursos.cursos.fecha)'))
            ->get();
    }

    private function getCursosTodosPorAnioYMes()
    {
        return $this->getCursos()
            ->select(DB::raw('count(*) as cantidad,EXTRACT(ISOYEAR FROM cursos.cursos.fecha) as anio,EXTRACT(MONTH FROM cursos.cursos.fecha) as mes'))
            ->where(DB::raw('EXTRACT(ISOYEAR FROM cursos.cursos.fecha)'), '>=', '2013')
            ->groupBy(DB::raw('EXTRACT(ISOYEAR FROM cursos.cursos.fecha),EXTRACT(MONTH FROM cursos.cursos.fecha)'))
            ->orderBy(DB::raw('EXTRACT(ISOYEAR FROM cursos.cursos.fecha),EXTRACT(MONTH FROM cursos.cursos.fecha)'))
            ->get();
    }

    private function getCountCursosPorProvincia()
    {
        return $this->getCursos()
            ->join('sistema.provincias', 'cursos.id_provincia', '=', 'sistema.provincias.id_provincia')
            ->select('sistema.provincias.nombre as label', DB::raw('count(*) as value'))
            ->groupBy('sistema.provincias.id_provincia')
            ->get();
    }

    private function to_highchart_pie()
    {
        $cursos = $this->getCountCursosPorLineaEstrategica();
        
        $total = $cursos->reduce(
            function ($carry, $value) {
                return $carry + $value->value;
            }
        );

        $data = array();

        $cursos->each(
            function ($value, $item) use ($total, &$data) {
                $array = array('name' => $value->label,'y' => $value->value * 100 / $total);
                array_push($data, $array);
            }
        );

        $ret = array('name' => 'Lineas','data' => $data);

        return array($ret);
    }

    public function getCursosPorAnioHc()
    {
        $cursos_por_anio = $this->getCursosPorAnio();
        
        $data = array();

        $cursos_por_anio->each(
            function ($value, $item) use (&$data) {
                $array = array(
                'name' => $value->anio,
                'y' => $value->cantidad,
                'drilldown' => $value->anio);
                array_push($data, $array);
            }
        );

        $series = array(
         'name' => 'Cursos',
         'colorByPoint' => true,
         'data' => $data);

        return array($series);
    }

    public function getCursosPorAnioYMesHc()
    {
        $cursos_por_anio = $this->getCursosPorAnio();
        
        $ret = array();

        $cursos_por_anio->each(
            function ($value, $item) use (&$ret) {

                $cursos_del_anio = $this->getCursosPorAnioYMes($value->anio);
                $data = array();

                $cursos_del_anio->each(
                    function ($value, $key) use (&$data) {
                        /*$mes = $this->$nombre_mes[(int)$value->mes];*/
                        array_push($data, array($value->mes,$value->cantidad));
                    }
                );

                $drilldown = array(
                'name' => $value->anio,
                'id' => $value->anio,
                'data' => $data);
            
                array_push($ret, $drilldown);
            }
        );
        return $ret;
    }

    public function accionesAnioMes()
    {
        $acciones = \DB::select("(select extract(year from fecha) as anio,extract(month from fecha) as mes,count(*) as cantidad from cursos.cursos
where fecha > '2013-01-01'
group by extract(year from fecha),extract(month from fecha)
order by extract(year from fecha),extract(month from fecha))
union all
(select max(extract(year from fecha)),generate_series((select extract(month from max(fecha))::numeric) + 1,12),0 from cursos.cursos)");

        return collect($acciones)
            ->groupBy('anio')
            ->map(function ($acciones,$anio) {
                return array(
                    'name' => $anio,
                    'data' => array_map(function ($dato) {
                        return $dato->cantidad;
                        }, $acciones->toArray())
                );
            })
            ->values()
            ->toArray();
    }
}
