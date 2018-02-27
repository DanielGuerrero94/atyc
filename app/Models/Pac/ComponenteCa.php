<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ComponenteCa extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "pac.componentes_ca";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_componente_ca';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['pivot'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'anio_vigencia'];
    
    public static function table()
    {
        return ComponenteCa::all();
    }

    /**
    *
    *
    *
    */
    public function crear(Request $r)
    {
        $this->nombre = $r->nombre;
        $this->anio_vigencia = $r->anio_vigencia;
        $this->save();
    }

    public function modificar(Request $r)
    {
        $this->nombre = $r->nombre;
        $this->anio_vigencia = $r->anio_vigencia;
        $this->save();
    }
}
