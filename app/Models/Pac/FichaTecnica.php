<?php

namespace App\Models\Pac;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FichaTecnica extends Model
{
    use SoftDeletes;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['path', 'original', 'aprobada'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.fichas_tecnicas';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_ficha_tecnica';

    public $timestamps = true;

    public function pac()
    {
        return $this->belongsTo(
            'App\Models\Pac\Pac',
            'id_ficha_tecnica',
            'id_ficha_tecnica'
        );
    }

}
