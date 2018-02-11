<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sistema.etapas';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_etapa';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_etapa', 'nombre'];
}
