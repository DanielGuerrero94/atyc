<?php

namespace App\Http\Controllers;

use App\Models\Pac\FichaTecnica as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Datatables;

class FichaTecnicaController extends Controller
{
    protected $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->formatRequestData($request);        
        return $this->model->create($data)->id_ficha_tecnica;
    }

    public function download($id)
    {
        $ficha_tecnica = FichaTecnica::findOrFail($id);
        $path = storage_path("app/ficha_tecnica/".$ficha_tecnica->path);
        return response()->download($path, $ficha_tecnica->original);
    }

    public function replace(Request $request, $id)
    {
        $data = $this->formatRequestData($request);        
        $material = $this->model->findOrFail($id);
        Storage::delete($material->path);
        $material->update($data);
        return response('Replaced', 200);
    }
    
    public function aprobar($id) {
       return $this->model->findOrFail($id)->aprobar(); 
    }

    public function formatRequestData(Request $request) {
        $path = $request->file('csv')->store('ficha_tecnica');
        $path = explode('/', $path);
        $path = $path[1];
        $original = $request->file('csv')->getClientOriginalName();

        return compact('original', 'path');
    }

}
