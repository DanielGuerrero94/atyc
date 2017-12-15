<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Estado extends Model
{
    protected $table = "pac.estados";

    protected $fillable = ['nombre'];

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_estado';

    /**
     * Get las Pacs con ese estado.
     */
    public function cursos()
    {
        return $this->hasMany('App\Models\Cursos\Curso');
        return $this->belongsToMany('App\Models\Cursos\Curso', 'cursos.cursos_estados', 'id_curso', 'id_estado')->withTimestamps();
    }

    public static function table()
    {
        return Estado::all();
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
    }

    public function modificar(Request $r)
    {
        $this->nombre = $r->nombre;
        $this->save();
    }
}
