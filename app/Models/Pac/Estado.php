<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = "pac.estados";

    protected $fillable = ['nombre'];

    /**
     * Get las Pacs con ese estado.
     */
    public function cursos()
    {
        return $this->hasMany('App\Models\Cursos\Curso');
        return $this->belongsToMany('App\Models\Cursos\Curso', 'cursos.cursos_estados', 'id_curso', 'id_estado')->withTimestamps();
    }

    /**
    *
    *
    *
    */
    public function crear(Request $r)
    {
        $this->nombre = $r->nombre;
        $this->save();
        return $this;
    }
}
