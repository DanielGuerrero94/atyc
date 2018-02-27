<?php

namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pac extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "pac.pac";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_pac';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['pivot'];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 't1', 't2', 't3', 't4', 'observado', 'id_provincia', 'id_ficha_tecnica'];

    /**
     * Acciones planificadas.
     */
    public function acciones()
    {
        return $this->belongsToMany('App\Models\Cursos\Curso', 'pac.pacs_cursos', 'id_pac', 'id_curso')
            //->withTimestamps()
            ;
    }

    /**
     * Las pacs de una pauta.
     */
    public function pautas()
    {
        return $this->belongsToMany('App\Models\Pac\Pauta', 'pac.pacs_pautas', 'id_pac', 'id_pauta')->withTimestamps();
    }

    /**
     * Componentes del compromiso anual.
     */
    public function componentesCa()
    {
        return $this->belongsToMany('App\Models\Pac\ComponenteCa', 'pac.pacs_componentes_ca', 'id_pac', 'id_componente_ca')->withTimestamps();
    }

    /**
     * Destinatarios de las acciones planificadas.
     */
    public function destinatarios()
    {
        return $this->belongsToMany('App\Funcion', 'pac.pacs_destinatarios', 'id_pac', 'id_funcion')->withTimestamps();
    }

    /**
     * Ficha tecnica.
     */
    public function ficha_tecnica()
    {
        return $this->hasOne('App\FichaTecnica', 'id_ficha_tecnica', 'id_ficha_tecnica');
    }
    
    public function generarAcciones($accion)
    {

        $areasTematicas = explode(',', $accion['areasTematicas']);

        while ($accion['repeticiones']--) {
            $this->acciones()
                ->create($accion)
                ->areasTematicas()
                ->attach($areasTematicas);
        }

        return $this;
    }

    public function llenarRelaciones($relaciones)
    {

        $destinatarios = explode(',', $relaciones['destinatarios']);
        $componentes = explode(',', $relaciones['componentesCa']);
        $pautas = explode(',', $relaciones['pautas']);

        $this->destinatarios()->attach($destinatarios);
        $this->componentesCa()->attach($componentes);
        $this->pautas()->attach($pautas);

        return $this;
    }
}
