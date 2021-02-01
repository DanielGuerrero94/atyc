<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actor extends Model
{
    use SoftDeletes;

    const SUMAR = 1;
    const REDES = 2;
    const PROTEGER = 3;
    const TELESALUD = 4;
    const INTEGRADO = 5;

    protected $fillable = ['nombre', 'descripcion'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'pac.actores';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_actor';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

}
