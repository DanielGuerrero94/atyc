<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class PacCambioEstado extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.cambios_estado';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'mensaje',
        'id_pac',
        'id_estado_anterior',
        'id_estado_nuevo',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function pac()
    {
        return $this->hasOne(
            Pac::class,
            'id_pac',
            'id_pac'
        );
    }

    public function estadoNuevo()
    {
        return $this->hasOne(
            PacEstado::class,
            'id_estado',
            'id_estado_nuevo'
        );
    }

    public function estadoAnterior()
    {
        return $this->hasOne(
            PacEstado::class,
            'id_estado',
            'id_estado_anterior'
        );
    }
}
