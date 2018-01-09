<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
	protected $table = 'sistema.materiales';

    protected $primaryKey = 'id_material';

    protected $fillable = ['path', 'original', 'descripcion'];
}
