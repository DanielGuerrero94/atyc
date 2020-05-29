<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pac\Pauta;
use App\Models\Pac\Categoria;
use Datatables;

class PautasController extends ModelController
{
    /**
     * Rules for the validator
     *
     * @var array
     **/
    protected $rules = [
        'numero' => 'required|numeric',
        'nombre' => 'required|string',
        'id_categoria' => 'required|numeric',
        'ficha_obligatoria' => 'required',
        'anios' => 'required'
    ];

    protected $name = 'pauta';

    public function __construct(Pauta $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->model
        ->orderBy('deleted_at', 'desc')
        ->orderBy('numero')
        ->withTrashed();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pautas/alta', ['categorias' => Categoria::withTrashed()->get()]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        logger(json_encode($request));
        $pauta = ModelController::store($request);

        $anios = explode(',', $request->get('anios'));
        logger(json_encode($anios));

        foreach($anios as $anio)
            DB::insert('insert into pac.pautas_anios (id_pauta, anio) values (?, ?)', [$pauta->id_pauta, $anio]);

        return $pauta;
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = ModelController::update($request, $id);
        
        $pauta = $this->model->withTrashed()->findOrFail($id);

        $current_years = array();
        foreach($this->anios($id) as $anio) {
            $current_years[] = $anio->anio;
        };

        $new_years = explode(',', $request->get('anios'));
        
        $intersect = array_intersect($current_years, $new_years);

        $deleted_years = array_diff($current_years, $intersect);
        $added_years = array_diff($new_years, $intersect);

        // logger()->info(json_encode($current_years));
        // logger()->info(json_encode($new_years));
        // logger()->info(json_encode($intersect));
        // logger()->info(json_encode($deleted_years));
        // logger()->info(json_encode($added_years));

        foreach($deleted_years as $year)
            DB::table('pac.pautas_anios')->where('id_pauta', $id)->where('anio', $year)->delete();
        foreach($added_years as $year)
            DB::insert('insert into pac.pautas_anios (id_pauta, anio) values (?, ?)', [$id, $year]);

        return $response;
    }

    public function show($id)
    {
        return [
            $this->name => $this->model
                ->with(['categoria' => function ($categoria) {
                    return $categoria->withTrashed();
                }])
                ->withTrashed()
                ->findOrFail($id),
            'categorias' => Categoria::withTrashed()->get(),
            'anios' => $this->anios($id)];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pautas/modificar', $this->show($id));
    }

    /**
     * View para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodos()
    {
        return view('pautas');
    }
    
    /**
     * Devuelve la informacion para abm.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTabla(Request $r)
    {
        $filtros = collect($r->only('filtros'));
        $anios = $filtros['filtros']['anios'];

        if(!empty($anios)) {
            $ids = DB::table('pac.pautas_anios')
            ->select('id_pauta')
            ->whereIn('pac.pautas_anios.anio', $anios)
            ->distinct()
            ->get()
            ->toArray();

            logger()->info(json_encode($ids));

            $ids = array_map(function ($val) {
                return $val->id_pauta;
            }, $ids);

            $filtered = $this->index()->whereIn('id_pauta', $ids)->get();
        } else {
            $filtered = $this->index()->get();
        }


        return Datatables::of($filtered)
        ->addColumn(
            'anios',
            function ($ret) {
                return array($this->anios($ret->id_pauta));
            }
        )
        ->addColumn(
            'acciones',
            function ($ret) {
                $buttons = '<a data-id="'.$ret->id_pauta.'" class="btn btn-circle editar" '.
                'title="Editar" style="margin-right: 1rem;"><i class="fa fa-pencil" aria-hidden="true" style="color: dodgerblue;"></i></a>';

                if($ret->deleted_at)
                    $buttons .= '<a data-id="'.$ret->id_pauta.'" class="btn btn-circle darAlta" '.
                    'title="Dar de alta" style="margin-right: 1rem;"><i class="fa fa-plus" aria-hidden="true" style="color: forestgreen;"></i></a>';
                else
                    $buttons .= '<a data-id="'.$ret->id_pauta.'" class="btn btn-circle darBaja" '.
                    'title="Dar de baja" style="margin-right: 1rem;"><i class="fa fa-minus" aria-hidden="true" style="color: firebrick;"></i></a>';
                
                if($this->seCreoLaMismaSemana($ret))
                    $buttons .= '<a data-id="'.$ret->id_pauta.'" class="btn btn-circle eliminar" '.
                'title="Eliminar" style="margin-right: 1rem;"><i class="fa fa-trash" aria-hidden="true" style="color: dimgray;"></i></a>';

                return $buttons;
            }
        )
        ->make(true);
    }

    public function obligarFichaTecnica($id_pauta)
    {
        $pauta = Pauta::findOrFail($id_pauta);
        $pauta->ficha_obligatoria = true;
        $pauta->save();

        return response('Obligado');
    }

    public function desobligarFichaTecnica($id_pauta)
    {
        $pauta = Pauta::findOrFail($id_pauta);
        logger("encontre pauta: ".$id_pauta);
        $pauta->ficha_obligatoria = false;
        $pauta->save();

        return response('Desobligado');
    }

    public function anios($id_pauta)
    {
        $anios = DB::table('pac.pautas_anios')
        ->select('anio')
        ->where('id_pauta', $id_pauta)
        ->get();

        // foreach($anios as $anio)
        //     logger(json_encode($anio->anio));

        return $anios;
    }

    public function hardDestroy($id)
    {
        $anios = DB::table('pac.pautas_anios')
        ->where('id_pauta', $id)
        ->delete();

        return ModelController::hardDestroy($id);
    }
}