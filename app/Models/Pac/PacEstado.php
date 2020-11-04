<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PacEstado extends Model
{
    use SoftDeletes;

    const ACCION_NUEVA = 1;
    const ACCION_EN_REVISION = 2;
    const ACCION_APROBADA = 3;
    const ACCION_RECHAZADA = 4;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.estados';

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
    protected $fillable = [
        'id_estado',
        'nombre',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function pacs()
    {
        return $this->belongsTo(Pac::class, 'id_estado', 'id_estado');
    }

}
