<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modalidad extends Model
{
    use SoftDeletes;

    const PRESENCIAL        = 1;
    const VIRTUAL           = 2;
    const DISPOSITIVO_TEXTO = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cursos.modalidades';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_modalidad';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'created_at',
        'updated_at',
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

    public function lineasEstrategicas()
    {
        return $this->belongsToMany(
            LineaEstrategica::class,
            "cursos.lineas_estrategicas_modalidades",
            "id_modalidad",
            "id_linea_estrategica"
        );
    }
}
