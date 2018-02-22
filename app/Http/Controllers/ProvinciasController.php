<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provincia;

class ProvinciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Provincia::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Provincia::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function localidadesTypeahead(Request $r)
    {
        return array(
            'status' => true,
            'error' => null,
            'data' => array(
                'localidades' => $this->getLocalidades($r->id_provincia, $r->q)
                )
            );
    }

    public function getLocalidades($id_provincia, $typed)
    {
        $query = \DB::table('geo.localidades')
        ->select('id', 'nombre_localidad')
        ->where('nombre_localidad', 'ilike', "%{$typed}%");

        if ($id_provincia != 0) {
            $id_provincia = $id_provincia < 10?"0".strval($id_provincia):strval($id_provincia);
            $query = $query->where('id_provincia', $id_provincia);
        }

        return $query->get()->toArray();
    }
}
