<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'pac.responsables';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_responsable';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}

