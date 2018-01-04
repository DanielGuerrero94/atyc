<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursos\Curso;
use DB;
use Auth;
use Datatables;

class EfectoresController extends Controller
{
    private $filters_map = [
        'id_provincia' => 'p',
        'descripcion' => 'p',
        'siisa' => 'e',
        'cuie' => 'e',
        'nombre' => 'e',
        'denominacion_legal' => 'e',
        'domicilio' => 'e',
        'id_departamento' => 'd',
        'nombre_departamento' => 'd',
        'id_localidad' => 'l',
        'nombre_localidad' => 'l',
        'codigo_postal' => 'e',
        'ciudad' => 'dg',
    ];

    public function get()
    {
        $provincias = [];

        if (Auth::user()->id_provincia == 25) {
            $provincias = Provincia::all()->where('id_provincia','<>','25');    
        }
        
        return view('efectores', compact('provincias'));
    }

    public function queryLogica(Request $r, $filtros = [])
    {
        $query = DB::table('efectores.efectores as e')
        ->join('efectores.datos_geograficos as dg', 'dg.id_efector', '=', 'e.id_efector')
        ->join('geo.provincias as p', 'p.id_provincia', '=', 'dg.id_provincia')
        ->join('geo.departamentos as d', 'd.id', '=', 'dg.id_departamento')
        ->join('geo.localidades as l', 'l.id', '=', 'dg.id_localidad');

        if ($filtros->pop('capacitados')) {
            $query = $query->join('alumnos.alumnos as al', 'al.establecimiento1', '=', 'e.cuie');
        }

        $query = $query->select(
            'p.id_provincia',
            'p.descripcion as provincia',
            'e.siisa',
            'e.cuie',
            'e.nombre',
            'e.denominacion_legal',
            'e.domicilio',
            'd.id_departamento',
            'd.nombre_departamento as departamento',
            'l.id_localidad',
            'l.nombre_localidad as localidad',
            'e.codigo_postal',
            'dg.ciudad'
        )
        ->where('e.id_estado', 1);

        foreach ($filtros as $key => $value) {
            if ($key == 'id_provincia') {
                $query = $this->segunProvincia($query, $value);
            } else {
                $query = $query->where($this->mapearColumna($key), $value);
            }
        }

        $query = $query->groupBy(
            'p.id_provincia',
            'p.descripcion',
            'e.siisa',
            'e.cuie',
            'e.nombre',
            'e.denominacion_legal',
            'e.domicilio',
            'd.id_departamento',
            'd.nombre_departamento',
            'l.id_localidad',
            'l.nombre_localidad',
            'e.codigo_postal',
            'dg.ciudad'
        );
        
        return $query;
    }

    /**
     * Inicial de la tabla y el nombre de la columna segun el key del filtro que le pasen
     * @return string
     */
    public function mapearColumna($key)
    {
        return $this->filters_map[$key].'.'.$key;
    }

    public function reporte()
    {
        $desde = '2017-01-01';
        $hasta = '2017-12-31';
        $provincia = '24';


        return DB::table('efectores.efectores as e')
        ->join('efectores.datos_geograficos as dg', 'dg.id_efector', '=', 'e.id_efector')
        ->join('geo.provincias as p', 'p.id_provincia', '=', 'dg.id_provincia')
        ->join('geo.departamentos as d', 'd.id', '=', 'dg.id_departamento')
        ->join('geo.localidades as l', 'l.id', '=', 'dg.id_localidad')
        ->join('alumnos.alumnos as a', 'a.establecimiento1', '=', 'e.cuie')
        ->join('cursos.cursos_alumnos as ca', 'ca.id_alumno', '=', 'a.id_alumno')
        ->join('cursos.cursos as c', 'c.id_curso', '=', 'ca.id_curso')
        ->rightJoin('sistema.periodos as pe', function ($join) {
            return $join->whereBetween('c.fecha', [DB::raw('to_date(pe.desde::text,\'YYYY-MM-DD\')'),
                DB::raw('to_date(pe.hasta::text,\'YYYY-MM-DD\')')]);
        })
        //->crossJoin('sistema.periodos as pe')
        ->select(
            'pe.nombre as periodo',
            'p.descripcion as provincia',
            'e.cuie',
            'e.nombre as efector',
            'e.denominacion_legal',
            'd.nombre_departamento as departamento',
            'l.nombre_localidad as localidad',
            'c.nombre as accion',
            'c.fecha',
            DB::raw('count(*) as participantes')
        )
        //->whereBetween(DB::raw('c.fecha between pe.desde and pe.hasta'))
        //->where(DB::raw('c.fecha between pe.desde and pe.hasta'))
        //->where('dg.id_provincia',$provincia)
        ->groupBy(
            'pe.nombre',
            'p.descripcion',
            'e.cuie',
            'e.nombre',
            'e.denominacion_legal',
            'd.nombre_departamento',
            'l.nombre_localidad',
            'c.nombre',
            'c.fecha'
        );

        /*return DB::table('efectores.efectores as e')
        ->join('efectores.datos_geograficos as dg', 'dg.id_efector', '=', 'e.id_efector')
        ->join('geo.provincias as p', 'p.id_provincia', '=', 'dg.id_provincia')
        ->join('geo.departamentos as d', 'd.id', '=', 'dg.id_departamento')
        ->join('geo.localidades as l', 'l.id', '=', 'dg.id_localidad')
        ->join('alumnos.alumnos as a', 'a.establecimiento1', '=', 'e.cuie')        
        ->join('cursos.cursos_alumnos as ca', 'ca.id_alumno', '=', 'a.id_alumno')
        ->join('cursos.cursos as c', 'c.id_curso', '=', 'ca.id_curso')
        ->select('p.descripcion as provincia', 'e.cuie', 'e.nombre as efector', 'e.denominacion_legal',
        'd.nombre_departamento as departamento', 'l.nombre_localidad as localidad', 'c.nombre as accion', 'c.fecha',
        DB::raw('count(*) as participantes'))
        ->whereBetween('c.fecha',[$desde,$hasta])
        ->where('dg.id_provincia',$provincia)
        ->groupBy('p.descripcion', 'e.cuie', 'e.nombre', 'e.denominacion_legal', 'd.nombre_departamento',
        'l.nombre_localidad', 'c.nombre', 'c.fecha');*/
    }

    public function getTabla(Request $r)
    {
        $query = $this->queryLogica($r, collect(['capacitados' => true]));

        return Datatables::of($query)
        ->addColumn('acciones', function ($ret) {
            $ver_historial = '<a href="efectores/'.$ret->cuie.'/cursos"><button class="btn btn-info" '.
            'title="Historial"><i class="fa fa-calendar" aria-hidden="true"></i> Historial</button></a>';
            return $ver_historial;
        })
        ->make(true);
    }

    public function toTypeahead($array)
    {
        return [
            'status' => true,
            'error' => null,
            'data' => $array
        ];
    }

    public function nombresTypeahead(Request $r)
    {
        return $this->toTypeahead(['nombres' => $this->getNombres($r)]);
    }

    public function cuiesTypeahead(Request $r)
    {
        return $this->toTypeahead(['cuies' => $this->getCuies($r)]);
    }

    public function getNombres(Request $r)
    {
        $query = DB::table('efectores.efectores as e')
        ->join('efectores.datos_geograficos as dg', 'e.id_efector', '=', 'dg.id_efector')
        ->select('e.nombre')
        ->whereRaw("efectores.efectores.nombre ~* '{$r->q}'")
        ->pluck('e.nombre')
        ->orderBy('e.nombre');

        return $this->segunProvincia($query, $r->id_provincia)
        ->get()
        ->toArray();
    }

    public function getCuies(Request $r)
    {
        $query = DB::table('efectores.efectores as e')
        ->join('efectores.datos_geograficos as dg', 'e.id_efector', '=', 'dg.id_efector')
        ->select('e.cuie')
        ->whereRaw("efectores.efectores.cuie ~* '{$r->q}'")
        ->pluck('e.cuie')
        ->orderBy('e.cuie');

        return $this->segunProvincia($query, $r->id_provincia)
        ->get()
        ->toArray();
    }

    public function mapearProvincia($id_provincia)
    {
        return $id_provincia < 10?"0".strval($id_provincia):strval($id_provincia);
    }

    public function segunProvincia($query, $id_provincia)
    {
        if ($id_provincia != 0) {
            $id_provincia = $this->mapearProvincia($id_provincia);

            $query = $query->where('dg.id_provincia', $id_provincia);
        }

        return $query;
    }

    public function historialCursos(Request $r, $cuie)
    {
        $efector = $this->queryLogica($r, collect(['capacitados' => true]));

        $provincia = Auth::user()->id_provincia;

        if ($provincia != 25) {
            $efector = $efector
            ->where('dg.id_provincia', $provincia);
        }

        $efector = $efector
        ->where('e.cuie', $cuie)
        ->first();

        $cursos = Curso::getByCuie($cuie);

        return view('efectores/historial_cursos', compact('efector', 'cursos'));
    }

    public function findCuie($string)
    {   
        if ($this->esCuie($string)) {
            return $string;
        }

        $efector = DB::table('efectores.efectores as e')
        ->select('e.cuie')
        ->where('e.nombre', $string)
        ->first();

        return $efector?$efector->cuie:$efector;
    }

    /**
     * Regex de los caracteres de cuie posibles
     *
     * @param
     */
    public function esCuie($string)
    {
        return preg_match('/[A-HJ-NP-Z][0-9]{5}/', $string);
    }

    public function efectoresSegunProvincia($id_provincia)
    {
        $request = new Illuminate\Http\Request(['filtros' => ['id_provincia' => $id_provincia]]);
        return $this->queryLogica($request)->get();
    }

    public function filtrar(Request $r)
    {
        $filtros = collect($r->get('filtros'))
        ->mapWithKeys(function ($item) {
            return $item;
        });

        $query = $this->queryLogica($r, $filtros);

        return Datatables::of($query)
        ->addColumn('acciones', function ($ret) {
            $ver_historial = '<a href="efectores/'.$ret->cuie.'/cursos"><button class="btn btn-info" '.
            'title="Historial"><i class="fa fa-calendar" aria-hidden="true"></i> Historial</button></a>';
            return $ver_historial;
        })
        ->make(true);
    }

    public function selectDepartamentos(Request $r, $id_provincia)
    {
        return DB::table('geo.provincias as p')
        ->join('geo.departamentos as d', 'd.id_provincia', '=', 'p.id_provincia')
        ->select('id', 'nombre_departamento')
        ->where('p.id_provincia', $this->mapearProvincia($id_provincia));
        ->orderBy('nombre_departamento')
        ->get();
    }

    public function selectLocalidad(Request $r, $id_provincia, $id_departamento)
    {
        return DB::table('geo.provincias as p')
        ->join('geo.departamentos as d', 'd.id_provincia', '=', 'p.id_provincia')
        ->join('geo.localidades as l', 'l.id_departamento', '=', 'd.id_departamento')
        ->select('id', 'nombre_departamento')
        ->where('p.id_provincia', $this->mapearProvincia($id_provincia))
        ->where('d.id', $id_departamento)
        ->orderBy('nombre_departamento')
        ->get();
    }
}
