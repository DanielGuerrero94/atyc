<?php
 
namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Pauta extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "pac.pautas";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_pauta';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['pivot'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['item', 'nombre', 'descripcion', 'id_categoria_pauta', 'vigencia', 'id_provincia', 'requiere_ficha_tecnica'];

    /**
     * Get la CategoriaPauta de una Pauta.
     */
    public function categoriaPauta()
    {
        return $this->hasOne('App\Models\Pac\CategoriaPauta', 'id_categoria_pauta', 'id_categoria_pauta');
    }

    /**
     * Relacion con los componentes del compromiso anual.
     */
    public function componentes()
    {
        return $this->belongsToMany(
            'App\Models\Pac\ComponenteCa',
            'pac.pautas_componentes',
            'id_componente_ca',
            'id_pauta'
        )
            ->withTimestamps();
    }

        
    /**
    *
    *
    *
    */
    public function crear(Request $r)
    {
        $this->item                = $r->item;
        $this->nombre              = $r->nombre;
        $this->descripcion         = $r->descripcion;
        $this->id_categoria_pauta  = $r->id_categoria_pauta;
        $this->vigencia            = $r->vigencia;
        $this->id_provincia        = $r->id_provincia;
        $this->save();
        return $this;
    }

    public function modificar(Request $r)
    {
        $this->item                = $r->item;
        $this->nombre              = $r->nombre;
        $this->descripcion         = $r->descripcion;
        $this->id_categoria_pauta  = $r->id_categoria_pauta;
        $this->vigencia            = $r->vigencia;
        $this->id_provincia        = $r->id_provincia;
        $this->save();
        return $this;
    }
}
