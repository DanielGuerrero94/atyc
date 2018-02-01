<?php

namespace App\Http\Controllers;

use App\Pais;
use App\Traits\TypeaheadResponseTrait;
use Illuminate\Http\Request;

class PaisesController extends Controller
{
    use TypeaheadResponseTrait;

    public function getNombres()
    {
        $paises = Pais::select('nombre')->get()->toArray();

        return $this->typeaheadResponse($paises);
    }

    public function getIdByNombre($nombre)
    {
        return Pais::select('id_pais')->where('nombre', $nombre)->get();
    }

    public function getNombreById($id)
    {
        return Pais::findOrFail($id)->nombre;
    }
}
