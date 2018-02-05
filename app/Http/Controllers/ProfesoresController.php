<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\TipoDocente;
use App\TipoDocumento;
use App\Profesor;
use App\Pais;
use Cache;
use DB;
use Auth;
use Log;
use Validator;
use Datatables;
use Excel;
use App\PDF as Pdf;

class ProfesoresController extends AbmController
{

    private $rules = [
        'nombres' => 'required|string',
        'apellidos' => 'required|string',
        'id_tipo_documento' => 'required|numeric',
        'id_tipo_docente' => 'required|numeric',
        'pais' => 'required_if:id_tipo_documento,5,6',
        'nro_doc' => 'required|numeric',
        'email' => 'nullable|email',
        'tel' => 'nullable|numeric',
        'cel' => 'nullable|numeric'
    ];

    private $filters = [
        'nombres' => 'string',
        'apellidos' => 'string',
        'id_tipo_documento' => 'numeric',
        'id_tipo_docente' => 'numeric',
        'cel' => 'numeric',
    //11
        'tel' => 'numeric',
    //Tiene que ser string porque si en el filtro no quieren ponerlo completo yo lo comparo con un ilike
        'email' => 'string',
        'nro_doc' => 'numeric'
    ];

    private $botones = [
        'fa fa-pencil-square-o',
        'fa fa-trash-o'
    ];

    public function query($query)
    {
        return DB::connection('eLearning')->select($query);
    }

    /**
    * View para abm.
    *
    * @return \Illuminate\Http\Response
    */
    public function get()
    {
        return view('profesores', $this->getSelectOptions());
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return Profesor::all();
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('profesores/alta', $this->getSelectOptions());
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        logger('Quiere crear docente con: '.json_encode($request->all()));
        $v = Validator::make($request->all(), $this->rules);
        
        if ($v->fails()) return response($v->errors(), 400);

        $docente = new Profesor();
        $docente = $docente->crear($request);
        return response($docente->toArray(), 200);
    }

    /**
        * Display the specified resource.
        *
        * @param  int $id
        * @return \Illuminate\Http\Response
        */
    public function show($id)
    {
        $profesor = Profesor::with(['tipoDocente'])->findOrFail($id);
        $r = [
            'profesor' => $profesor,
            'pais' => $profesor->getNombrePais()
        ];
        return array_merge($r, $this->getSelectOptions());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('profesores/modificar', $this->show($id));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  int                      $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        logger('Quiere actualizar docente {$id} con: '.json_encode($request->all()));
        try {
            $profesor = Profesor::findOrFail($id);
            if ($request->id_tipo_doc === '6' || $request->id_tipo_doc === '5') {
                $request->pais = Pais::select('id')->where('nombre', '=', $request->pais)->get('id')->first();
                $request->pais = $request->pais['id'];
            }
            return $profesor->modificar($request);
        } catch (ModelNotFoundException $e) {
            return json_encode($e->message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Profesor::findOrFail($id)->delete();
    }

    /**
     * Devuelve la informacion para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTabla(Request $r)
    {
        $query = Profesor::with('tipoDocumento', 'tipoDocente');

        return $this->toDatatable($r, $query);
    }

    private function queryLogica(Request $r, $filtros)
    {
        $query = Profesor::with('tipoDocumento', 'tipoDocente');

        foreach ($filtros as $key => $value) {
            if ($key == 'nombres' || $key == 'apellidos' || $key == 'email') {
                $query = $query->whereRaw("sistema.profesores.{$key} ~* '{$value}'");
            } else {
                $query = $query->where('sistema.profesores.'.$key, '=', $value);
            }
        }

        return $query;
    }

    public function getFiltrado(Request $r)
    {
        $filtros = collect($r->get('filtros'))
        ->mapWithKeys(function ($item) {
            return [$item['name'] => $item['value']] ;
        });

        $v = Validator::make($filtros->all(), $this->filters);

        if ($v->fails()) {
            return $v->errors();
        }
        
        $query = $this->queryLogica($r, $filtros);
        return $this->toDatatable($r, $query);
    }

    /**
     * Devuelve en DataTable los resultados con sus correspondientes acciones.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Collection               $resultados
     * @return \Illuminate\Http\Response
     */
    public function toDatatable(Request $r, $resultados)
    {
        return Datatables::of($resultados)
        ->addColumn(
            'acciones',
            function ($ret) use ($r) {

                $accion = $r->has('botones')?$r->botones:null;

                $agregar = '<button data-id="'.$ret->id_profesor.'" class="btn btn-info btn-xs agregar" '.
                'title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';

                return $accion == 'agregar'?$agregar:'';
            }
        )
        ->make(true);
    }

    /**
     * Opciones para los selects del front end.
     *
     * @return array
     */
    public function getSelectOptions()
    {
        $tipoDocumentos = Cache::remember('tipo_documentos', 5, function () {
            return TipoDocumento::all();
        });

        $tipoDocentes = Cache::remember('tipo_docentes', 5, function () {
            return TipoDocente::all();
        });

        return [
            'tipoDocumento' => $tipoDocumentos,
            'tipoDocente' => $tipoDocentes
        ];
    }

    /**
     * Buscar por numero de documento, nombres y apellidos de los docentes.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getTypeahead(Request $r)
    {
        $query = Profesor::select('id_profesor as id', 'nombres', 'apellidos', 'nro_doc as documentos');

        $typed = $r->input('q');
        if (is_numeric($typed)) {
            $query = $query->whereRaw("CAST(nro_doc as character varying) ~ '^{$typed}'");
        } else {
            $nombres = explode(' ', $typed);

            foreach ($nombres as $key => $value) {
                $query = $query->orWhereRaw("nombres ~* '{$value}'")
                ->orWhereRaw("apellidos ~* '{$value}'");
            }
        }

        $matchs = $query
        ->get();

        return $this->typeaheadResponse($matchs);
    }

    /**
     * Corre la query segun filtros y order_by
     * Guarda el resultado en un .xls
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response string path al archivo generado
     */
    public function getExcel(Request $r)
    {
        $filtros = collect($r->get('filtros'))
        ->mapWithKeys(function ($item) {
            return [$item['name'] => $item['value']] ;
        });

        $data = $this->queryLogica($r, $filtros)->get();
        $datos = ['profesores' => $data];
        $path = "docentes_".date("Y-m-d_H:i:s");

        Excel::create(
            $path,
            function ($excel) use ($datos) {
                $excel->sheet(
                    'Docentes',
                    function ($sheet) use ($datos) {
                        $sheet->setHeight(1, 20);
                        $sheet->loadView('excel.profesores', $datos);
                    }
                );
            }
        )
        ->store('xls');

        return $path;
    }

    /**
     * Corre la query segun filtros y order_by
     * Guarda el resultado en un .pdf
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response string path al archivo generado
     */
    public function getPDF(Request $r)
    {
        $filtros = collect($r->get('filtros'))
        ->mapWithKeys(function ($item) {
            return [$item['name'] => $item['value']] ;
        });

        $data = $this->queryLogica($r, $filtros)->get();
        $header = array('Nombres','Apellidos','Tipo doc','Nro doc');
        $column_size = array(65, 65, 25, 35);

        $mapped = $data->map(
            function ($item, $key) {
                return [
                    $item->nombres,
                    $item->apellidos,
                    $item->tipo_doc,
                    $item->nro_doc
                ];
            }
        );

        return Pdf::save($header, $column_size, 14, $mapped);
    }

    /**
     * Verifica si el numero de documento existe.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkDocumentos(Request $r)
    {
        return [
            'existe' => Profesor::where('nro_doc', $r->input('nro_doc'))
            ->count() != 0
        ];
    }

    /**
     * Show the form for seeing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function see($id)
    {
        return view('profesores/modificar', array_merge($this->show($id), ['disabled' => true]));
    }
}
