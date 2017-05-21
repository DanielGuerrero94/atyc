<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sistema.reportes';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_reporte';
}
