<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
	protected $table = 'materiales';

    protected $primaryKey = 'id_material';

    protected $fillable = ['path', 'original'];
}
