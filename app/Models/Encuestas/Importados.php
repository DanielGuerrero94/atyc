<?php

namespace App\Models\Encuestas;

use Illuminate\Database\Eloquent\Model;

class Importados extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'encuestas.importados';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_importado';
}
