<?php

namespace App\Http\Controllers;

use App\Etapa;
use App\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Datatables;

class MaterialesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Material::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id_etapa)
    {
        $path = $request->file('csv')->store('material');
        $path = explode('/', $path);
        $path = $path[1];
        $original = $request->file('csv')->getClientOriginalName();
        
        return Material::create(compact('original', 'path', 'id_etapa'))->id_material;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Material::findOrFail($id);
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
        Material::findOrFail($id)->update($request->all());
        return response('Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        Storage::delete('material/'.$material->path);
        $deleted = $material->delete();
        return json_encode($deleted);
    }

    public function listar($id_etapa)
    {
        $materiales = $this->generateList($id_etapa);
        return view('archivos.materiales', compact('materiales'));
    }

    public function download($id)
    {
        $material = Material::findOrFail($id);
        $path = storage_path("app/material/".$material->path);
        return response()->download($path, $material->original);
    }

    public function generateList($id_etapa)
    {
        $materiales = Material::where('id_etapa', $id_etapa)->get();
        $materiales = $this->setIcon($materiales);
        return $materiales;
    }

    public function setIcon($materiales)
    {
        /*
        Puede estar en otro lado esto y en front todavia no esta limitado a estas extensiones
        */
        $icon = [
            'csv' => 'fa-lg fa-file-excel-o text-success',
            'xls' => 'fa-lg fa-file-excel-o text-success',
            'xlsx' => 'fa-lg fa-file-excel-o text-success',
            'txt' => 'fa-lg fa-file-text-o',
            'sql' => 'fa-lg fa-file-code-o',
            'doc' => 'fa-lg fa-file-word-o text-primary',
            'docx' => 'fa-lg fa-file-word-o text-primary',
            'pdf' => 'fa-lg fa-file-pdf-o text-danger',
            'powerpoint' => 'fa-lg fa-file-powerpoint-o text-warning',
            'rar' => 'fa-lg fa-file-archive-o text-danger',
            'zip' => 'fa-lg fa-file-archive-o text-warning'
        ];


        return $materiales->map(function ($material) use ($icon) {
            //Consigue el sufijo y el nombre del archivo
            preg_match_all("/(.*)\.(\w+$)/", $material->original, $matches);
            $suffix = $matches[2][0];
            //Setea icono y color
            $material->icon = array_key_exists($suffix, $icon)?$icon[$suffix]:$icon['txt'];
            $material->original = $matches[1][0];
            return $material;
        });
    }

    /**
     * Returns the specified view for etapa.
     *
     * @param  int  $id_etapa
     * @return \Illuminate\Http\Response
     */
    public function view($id_etapa)
    {
        $etapa = Etapa::findOrFail($id_etapa);
        return view('archivos.archivos', ['etapa' => $etapa]);
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

    /**
     * Devuelve la informacion para abm.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $request['botones']
     * @return \Illuminate\Http\Response
     */
    public function table(Request $r, $id_etapa)
    {
        $materiales = Material::with('etapa')->where('id_etapa', $id_etapa);
        return $this->toDatatable($r, $materiales);
    }

    /**
     * Devuelve en DataTable los resultados.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $request['botones']
     * @param  Collection               $resultados
     * @return \Illuminate\Http\Response
     */
    public function toDatatable(Request $r, $resultados)
    {
        return Datatables::of($resultados)->make(true);
    }
}
