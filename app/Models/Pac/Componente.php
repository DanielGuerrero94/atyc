<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
    */
    protected $table = 'pac.componentes_cai_2020';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_componente';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;}
