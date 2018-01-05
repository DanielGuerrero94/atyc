<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ComponenteCa extends Model
{
    protected $table = "pac.componentes_ca";

    protected $fillable = ['nombre', 'anio_vigencia'];

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_componente_ca';

    /**
     * Las pacs de un caComponente.
     */
    public function pacs()
    {
        return $this->belongsToMany('App\Models\Pacs\Pac', 'pac.pacs_componentes_ca', 'id_pac', 'id_componente_ca')->withTimestamps();
    }	

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
