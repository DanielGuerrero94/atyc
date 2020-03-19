<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class Pauta extends Model
{

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'pac.pautas';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_pauta';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}
