<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;

class FichaTecnica extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.fichas_tecnicas';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_ficha_tecnica';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['path', 'original', 'comentarios'];

    public function aprobar() {
        $this->aprobada = true;
        $this->save();
        return $this;
    }

    public function getAprobadaAttribute($value) {
        return (boolean) $value;
    }
}

