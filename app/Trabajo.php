<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "alumnos.trabajos";

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_trabajo';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;    
}
