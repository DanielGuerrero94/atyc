<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcion extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alumnos.funciones';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_funcion';

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
    protected $fillable = ['nombre'];

    /**
     * Nombre de la columna que define el soft delete del trait.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Destinatarios de la pac.
     */
    public function pacs()
    {
        return $this->belongsToMany('App\Models\Pac\Pac', 'pac.pacs_destinatarios', 'id_pac', 'id_funcion')->withTimestamps();
    }    
}
