<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class AreaTematica extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cursos.areas_tematicas';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_area_tematica';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
     * Las cursos.
     */
    public function cursos()
    {
        return $this->belongsToMany('App\Curso', 'cursos.cursos_areas_tematicas', 'id_curso', 'id_area_tematica')->withTimestamps();
    }   

    public static function table()
    {
        return AreaTematica::all();
    }

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
