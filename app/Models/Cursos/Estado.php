<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Estado extends Model
{
    const CURSO_PLANIFICADO  = 1;
    const CURSO_DISENIADO    = 2;
    const CURSO_EN_EJECUCION = 3;
    const CURSO_FINALIZADO   = 4;
    const CURSO_REPROGRAMADO = 5;
    const CURSO_DESACTIVADO  = 6;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "cursos.estados";

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
    protected $fillable = ['nombre'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
