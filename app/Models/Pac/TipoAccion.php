<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class tipoAccion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.tipos_accion';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_accion';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
