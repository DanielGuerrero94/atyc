<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //No necesita
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = $request->file('csv')->store('material');
        $path = explode('/', $path);
        $path = $path[1];
        $original = $request->file('csv')->getClientOriginalName();

        return Material::create(compact('original', 'path'))->id_material;
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //No necesita
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
        //No necesita
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

    public function list()
    {
        $materiales = $this->generateList();
        return view('archivos.materiales', compact('materiales'));
    }

    public function download($id)
    {
        $material = Material::findOrFail($id);
        $path = storage_path("app/material/".$material->path);
        return response()->download($path, $material->original);
    }

    public function generateList()
    {
        $materiales = Material::select('id_material', 'original')->get();
        $materiales = $this->setIcon($materiales);
        return $materiales;
    }

    public function setIcon($materiales)
    {
        /*
        Puede estar en otro lado esto y en front todavia no esta limitado a estas extensiones
        */
        $icon = [
            'csv' => 'fa-file-excel-o text-success',
            'xls' => 'fa-file-excel-o text-success',
            'xlsx' => 'fa-file-excel-o text-success',
            'txt' => 'fa-file-text-o',
            'sql' => 'fa-file-code-o',
            'doc' => 'fa-file-word-o text-primary',
            'docx' => 'fa-file-word-o text-primary',
            'pdf' => 'fa-file-pdf-o text-danger',
            'powerpoint' => 'fa-file-powerpoint-o text-warning',
            'rar' => 'fa-file-archive-o text-danger',
            'zip' => 'fa-file-archive-o text-warning'
        ];

        return $materiales->map(function ($material) use ($icon) {
            //Consigue el sufijo
            $suffix = explode('.', $material->original);
            $suffix = $suffix[1];
            //Setea icono y color
            $material->icon = $icon[$suffix];
            //Recorta el nombre del archivo para que se vea bien en front, 16 esta muy hardcodeado
            $material->original = explode('.', $material->original);
            $material->original = substr($material->original[0], 0, 16);
            return $material;
        });
    }

    public function view()
    {
        return view('archivos.archivos');
    }
}
