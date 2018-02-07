<?php

namespace App\Models\Pac;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pac extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = ['nombre', 't1', 't2', 't3', 't4', 'observado', 'id_provincia'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.pacs';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_pac';

    public function destinatario()
    {
        return $this->hasOne('App\Models\Pac\Destinatario', 'id_destinatario', 'id_destinatario');
    }

    public function acciones()
    {
        return $this->belongsToMany('App\Models\Cursos\Curso', 'pac.pacs_cursos', 'id_curso', 'id_pac');
    }

    public function alcance()
    {
        return $this->hasOne('App\Models\Pac\Alcance', 'id_alcance', 'id_alcance');
    }

    public function profundizacion()
    {
        return $this->hasOne('App\Models\Pac\Profundizacion', 'id_profundizacion', 'id_profundizacion');
    }

    public function modalidad()
    {
        return $this->hasOne('App\Models\Pac\Modalidad', 'id_modalidad', 'id_modalidad');
    }

    public function insumos()
    {
        return $this->belongsToMany('App\Models\Pac\Insumo', 'pac_insumos', 'id_insumo', 'id_pac')->withTimestamps();
    }
}
