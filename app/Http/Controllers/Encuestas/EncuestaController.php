<?php

namespace App\Http\Controllers\Encuestas;

use Illuminate\Http\Request;
use App\Models\Encuestas\Encuesta;
use App\Http\Controllers\Controller;
use DB;

class EncuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(Encuesta::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Encuesta::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('encuestas.modificar',$this->show($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return Encuesta::findOrFail($id)->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Encuesta::findOrFail($id)->delete();
    }

    /**
     * Vista del menu encuestas.
     *
     * @return \Illuminate\Http\Response
     */
    public function g_plannacer()
    {
        return view('encuestas.g_plannacer');
    }

    /**
     * Vista del menu encuestas.
     *
     * @return \Illuminate\Http\Response
     */
    public function google_form()
    {
        return view('encuestas.google_form'); 
    }

    /**
     * Vista del menu encuestas.
     *
     * @return \Illuminate\Http\Response
     */
    public function survey()
    {
        return view('encuestas.survey');
    }

    /**
     * Vista del menu encuestas.
     *
     * @return \Illuminate\Http\Response
     */
    public function grafico()
    {
        return view('encuestas.grafico');
    }

    /**
     * Datos de encuestas del g_plannacer.
     * La diferencia es que van de ESCASO A MUY BUENO
     *
     * @return \Illuminate\Http\Response
     */
    public function g_plannacerDatos()
    {
        /*$var = Encuesta::select('pregunta.descripcion','id_respuesta',DB::raw('sum(cantidad) as cantidad'))
        ->with([
            'pregunta',
            'respuesta'
        ])
        ->groupBy('pregunta.descripcion,respuesta.id_respuesta')
        ->orderBy('pregunta.descripcion,respuesta.id_respuesta')
        ->get();*/

        $encuestas = \DB::select('select p.descripcion as pregunta,r.descripcion as respuesta,sum(cantidad) as cantidad from encuestas.encuestas e
            join encuestas.preguntas p using(id_pregunta)
            join encuestas.respuestas r using(id_respuesta)
            group by p.descripcion,r.id_respuesta
            order by p.descripcion,r.id_respuesta');



        //Lo ideal seria pasarle solo el nombre de la pregunta y en un array en orden los valores

        $ultimo = null;
        $datos = array();
        $ret = array();

        $encuestas = collect($encuestas)->each(function ($value,$item) use(&$ultimo,&$datos,&$ret)
        {
            if($value->pregunta != $ultimo){
                $array =  array(
                'pregunta' => $value->pregunta,
                'datos' => $datos);  
                array_push($ret,$array);
                $ultimo = $value->pregunta;
                $datos = array();              
            }

            array_push($datos,
                array($value->respuesta,$value->cantidad));

            return $ret; 
        });
                

        /*$asd = array('pregunta' => '1- LOS CONTENIDOS TEORICOS Y EL MATERIAL DIDACTICO OFRECIDO FUERON:','datos' => [12,12,14,98,47]);*/

        $r = array(
            'preguntas' => $ret);

        return json_encode($r);
    }
}
