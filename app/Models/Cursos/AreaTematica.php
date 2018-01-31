<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class AreaTematica extends Model
{
    use SoftDeletes;

    protected $table = 'cursos.areas_tematicas';

    protected $dates = ['deleted_at'];

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
     * Las pacs.
     */
    public function pacs()
    {
        return $this->belongsToMany('App\Models\Pacs\Pac', 'pac.pacs_areas_tematicas', 'id_pac', 'id_area_tematica')->withTimestamps();
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
