<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AccionPauta extends Model
{
    protected $table = "pac.acciones_pautas";

    protected $primaryKey = 'id_accion_pauta';

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
        return AccionPauta::all();
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
