<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class Destinatario extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.destinatarios';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_destinatario';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
