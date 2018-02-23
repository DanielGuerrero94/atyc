<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CategoriaPauta extends Model
{
    protected $table = "pac.categorias_pautas";

    protected $primaryKey = 'id_categoria_pauta';

    protected $fillable = ['item', 'nombre', 'descripcion', 'anio_vigencia'];

    /**
     * Get las Pautas con esta action.
     */
    public function pautas()
    {
        return $this->hasMany('App\Models\Pac\Pauta');
    }

    public static function table()
    {
        return CategoriaPauta::all();
    }
    /**
    *
    *
    *
    */
    public function crear(Request $r)
    {
        $this->item = $r->item;
        $this->nombre = $r->nombre;
        $this->descripcion = $r->descripcion;
        $this->anio_vigencia = $r->anio_vigencia;
        $this->save();
        return $this;
    }
}
