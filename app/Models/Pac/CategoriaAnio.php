<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class CategoriaAnio extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_categoria',
        'anio',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.categorias_anios';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = [
        'id_categoria',
        'anio',
    ];

    public $incrementing = false;

    public function categoria()
    {
        return $this->belongsTo(
            'App\Models\Pac\Categoria',
            'id_categoria',
            'id_categoria'
        );
    }
}
