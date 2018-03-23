<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class EstadoFichaTecnica extends Model
{
    protected $table = 'pac.estado_fichas_tecnicas';

    protected $primaryKey = 'id_estado_ficha_tecnica';

    protected $fillable = ['id_estado_ficha_tecnica', 'descripcion', 'class'];

    public $timestamps = false;
}
