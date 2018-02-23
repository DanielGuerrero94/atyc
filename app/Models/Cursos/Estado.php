<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Estado extends Model
{
    protected $table = "cursos.estados";

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_estado';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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
