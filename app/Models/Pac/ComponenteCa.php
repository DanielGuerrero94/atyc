<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponenteCa extends Model
{
    protected $table = "componentes_ca";

    protected $fillable = ['nombre', 'anio_vigencia'];

    /**
     * Las pacs de un caComponente.
     */
    public function cursos()
    {
        return $this->belongsToMany('App\Models\Cursos\Curso', 'cursos.cursos_componentes_ca', 'id_curso', 'id_componente_ca')->withTimestamps();
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
        return $this;
    }
}
