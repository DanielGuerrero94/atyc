<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'sistema.materiales';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_material';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['path', 'original', 'descripcion', 'id_etapa'];

    public function etapa()
    {
        return $this->hasOne('App\Etapa', 'id_etapa', 'id_etapa');
    }
}
