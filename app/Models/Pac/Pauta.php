<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pauta extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['numero', 'nombre', 'id_categoria', 'ficha_obligatoria', 'descripcion', 'id_provincia'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.pautas';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_pauta';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public function categoria()
    {
        return $this->belongsTo(
            'App\Models\Pac\Categoria',
            'id_categoria',
            'id_categoria'
        );
    }

    public function pacs()
    {
        return $this->hasMany(
            'App\Models\Pac\Pac',
            'id_pauta',
            'id_pauta'
        );
    }

    public function provincia()
    {
        return $this->belongsTo(
            'App\Provincia',
            'id_provincia',
            'id_provincia'
        );
    }
}
