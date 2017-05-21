<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alumnos.convenios';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_convenio';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
