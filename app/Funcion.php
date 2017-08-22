<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alumnos.funciones';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_funcion';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre'];
}
