<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class Modalidad extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.modalidades';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_modalidad';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;  
}
