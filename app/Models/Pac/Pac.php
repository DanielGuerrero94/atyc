<?php

namespace App\Models\Pac;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pac extends Model
{
    use SoftDeletes;

    protected $dates = ['fecha','created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['nombre', 'fecha', 'id_tipo_accion', 'ediciones', 'ficha_tecnica', 'id_provincia'];

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

    public function acciones()
    {
        return $this->belongsToMany('App\Models\Cursos\Curso', 'pac.pacs_cursos', 'id_pac', 'id_curso');
    }

    public function tipoAccion()
    {
        return $this->hasOne('App\Models\Pac\TipoAccion', 'id_accion', 'id_tipo_accion');
    }

    public function componentes()
    {
        return $this->belongsToMany('App\Models\Pac\Componente', 'pac.pacs_componentes', 'id_pac', 'id_componente');
    }

    public function tematicas()
    {
        return $this->belongsToMany('App\Models\Pac\Tematica', 'pac.pacs_tematicas', 'id_pac', 'id_tematica');
    }

    public function pautas()
    {
        return $this->belongsToMany('App\Models\Pac\Pauta', 'pac.pacs_pautas', 'id_pac', 'id_pauta');
    }

    public function destinatarios()
    {
        return $this->belongsToMany('App\Models\Pac\Destinatario', 'pac.pacs_destinatarios', 'id_pac', 'id_destinatario');
    }

    public function responsables()
    {
        return $this->belongsToMany('App\Models\Pac\Responsable', 'pac.pacs_responsables', 'id_pac', 'id_responsable');
    }

    public function provincia()
    {
        return $this->hasOne('App\Models\Sistema\Provincia', 'id_provincia', 'id_provincia');
    }
    public function scopeSegunProvincia($query)
    {
        $id_provincia = Auth::user()->id_provincia;
        if ($id_provincia != 25) {
            return $query->where('pacs.id_provincia', $id_provincia);
        }
    }
}
