<?php

namespace App\Models\Pac;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pac extends Model
{
    use SoftDeletes;

    protected $dates = [ 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['nombre', 'id_accion', 'ediciones', 'duracion', 'id_provincia', 'id_ficha_tecnica', 'anio', 'ficha_obligatoria'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pac.pacs';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_pac';

    // public function acciones()
    // {
    //     return $this->belongsToMany(
    //         'App\Models\Cursos\Curso',
    //         'pac.pacs_cursos',
    //         'id_pac',
    //         'id_curso')
    //         ->withTimeStamps();
    // }

    public function cursos()
    {
        return $this->hasMany(
            'App\Models\Cursos\Curso',
            'id_pac',
            'id_pac'
        );
    }

    public function tipoAccion()
    {
        return $this->hasOne(
            'App\Models\Cursos\LineaEstrategica',
            'id_linea_estrategica',
            'id_accion'
        );
    }

    public function componentes()
    {
        return $this->belongsToMany(
            'App\Models\Pac\Componente',
            'pac.pacs_componentes',
            'id_pac',
            'id_componente')
            ->withTimestamps();
    }

    public function tematicas()
    {
        return $this->belongsToMany(
            'App\Models\Cursos\AreaTematica',
            'pac.pacs_tematicas',
            'id_pac',
            'id_tematica')
            ->withTimestamps();
    }

    public function pautas()
    {
        return $this->belongsToMany(
            'App\Models\Pac\Pauta',
            'pac.pacs_pautas',
            'id_pac',
            'id_pauta')
            ->withTimestamps();
    }

    public function destinatarios()
    {
        return $this->belongsToMany(
            'App\Models\Pac\Destinatario',
            'pac.pacs_destinatarios',
            'id_pac',
            'id_destinatario')
            ->withTimestamps();
    }

    public function responsables()
    {
        return $this->belongsToMany(
            'App\Models\Pac\Responsable',
            'pac.pacs_responsables',
            'id_pac',
            'id_responsable')
            ->withTimestamps();
    }

    public function provincias()
    {
        return $this->hasOne(
            'App\Provincia',
            'id_provincia',
            'id_provincia'
        );
    }

    public function fichaTecnica()
    {
        return $this->hasOne(
            'App\Models\Pac\FichaTecnica',
            'id_ficha_tecnica',
            'id_ficha_tecnica');
    }

    public function scopeSegunProvincia($query)
    {
        $id_provincia = Auth::user()->id_provincia;
        if ($id_provincia != 25) {
            return $query->where('pacs.id_provincia', $id_provincia);
        }
    }
}
