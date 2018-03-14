<?php

namespace App\Http\Controllers;

use App\Models\Pac\FichaTecnica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Datatables;

class FichaTecnicaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = $request->file('csv')->store('ficha_tecnica');
        $path = explode('/', $path);
        $path = $path[1];
        $original = $request->file('csv')->getClientOriginalName();
        
        return FichaTecnica::create(compact('original', 'path'))->id_ficha_tecnica;
    }

    public function download($id)
    {
        $ficha_tecnica = FichaTecnica::findOrFail($id);
        $path = storage_path("app/ficha_tecnica/".$ficha_tecnica->path);
        return response()->download($path, $ficha_tecnica->original);
    }

    public function replace(Request $request, $id)
    {
        $path = $request->file('csv')->store('material');
        $path = explode('/', $path);
        $path = $path[1];
        $original = $request->file('csv')->getClientOriginalName();
        $material = Material::findOrFail($id);
        $replaced = $material->path;
        $material->update(compact('original', 'path'));
        Storage::delete($replaced);
        return response('Replaced', 200);
    }

}
