<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sistema.periodos';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_periodo';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
