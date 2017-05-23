<?php

namespace App\Models\Encuestas;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'encuestas.preguntas';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_pregunta';
}
