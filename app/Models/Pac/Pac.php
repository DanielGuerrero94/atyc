<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class Pac extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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

    public function accion()
    {
        return $this->hasOne('App\Accion', 'id_accion', 'id_accion');
    }

    public function pautas()
    {   
        return $this->belongsToMany('App\Models\Pac\Pauta','pac_pautas','id_pauta','id_pac')->withTimestamps();
    }

    public function insumos()
    {   
        return $this->belongsToMany('App\Models\Pac\Insumo','pac_insumos','id_insumo','id_pac')->withTimestamps();
    }

}
