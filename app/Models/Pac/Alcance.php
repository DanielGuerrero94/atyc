<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class Alcance extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.alcances';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_alcance';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
