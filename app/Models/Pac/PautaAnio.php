<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class PautaAnio extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pauta',
        'anio',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.pautas_anios';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = [
        'id_pauta',
        'anio',
    ];

    public $incrementing = false;

    public function pauta()
    {
        return $this->belongsTo(
            'App\Models\Pac\Pauta',
            'id_pauta',
            'id_pauta'
        );
    }
}
