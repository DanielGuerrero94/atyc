<?php
 
namespace App\Models\Pac;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Pauta extends Model
{
    protected $table = "pac.pautas";

    protected $fillable = ['nombre', 'descripcion', 'id_categoria_pauta', 'vigencia', 'id_provincia'];
    protected $primaryKey = 'id_pauta';

    /**
     * Las pacs de una pauta.
     */
    public function cursos()
    {
        return $this->belongsToMany('App\Models\Cursos\Curso', 'cursos.cursos_pautas', 'id_curso', 'id_pauta')->withTimestamps();
    }

    /**
     * Get la PautaAction de una Pauta.
     */
    public function accionesPautas()
    {
        return $this->belongsTo('App\Models\Pac\AccionPauta');
    }

    public function accionPauta()
    {
        return $this->hasOne('App\Models\Pac\CategoriaPauta', 'id_categoria_pauta', 'id_categoria_pauta');
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
