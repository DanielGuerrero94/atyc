<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sistema.tipos_documentos';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_tipo_documento';
}
