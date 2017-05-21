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
}
