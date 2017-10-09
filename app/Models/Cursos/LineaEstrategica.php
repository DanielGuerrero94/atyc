<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class LineaEstrategica extends Model
{
    use SoftDeletes;

    protected $table = 'cursos.lineas_estrategicas';

    protected $dates = ['deleted_at'];

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_linea_estrategica';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','numero'];
}
