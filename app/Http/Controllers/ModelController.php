<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Carbon\Carbon;

class ModelController extends Controller
{
/*
    use ValidatesRequests {
        validate as validateRequest;
    }
*/

    /**
     * Rules for the validator
     *
     * @var array
     **/
    protected $rules = [];

    /**
     * Model of the controller
     *
     * @var Illuminate\Database\Eloquent\Model
     **/
    protected $model;

    /**
     * Name of the Model
     *
     * @var string
     **/
    protected $name;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $name = lower_camel_case($this->name);
        return view("{$name}.alta");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error = $this->validate($request, $this->rules);

        if ($error) {
            return response($error, 400);
        }

        return $this->model->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return [$this->name => $this->model->withTrashed()->findOrFail($id)];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $name = lower_camel_case($this->name);
        return view("{$name}.modificacion", $this->show($id));
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
        $error = $this->validate($request, $this->rules);

        if ($error) {
            return response($error, 400);
        }
        
        return response()->json($this->model->withTrashed()->findOrFail($id)->update($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        logger("Voy a dar de baja: ".$id);
        return response()->json($this->model->findOrFail($id)->delete());
    }

    public function seCreoLaMismaSemana($ret)
    {
        $validTime = Carbon::now()->subDays(7);
        return $validTime <= $ret->created_at;
    }
    
    public function hardDestroy($id)
    {
        logger("Voy a destruir el registro: ".$id);
        return response()->json($this->model->withTrashed()->findOrFail($id)->forceDelete());
    }

    public function alta($id)
    {
        logger("Voy a dar de alta el id:".$id);
        return response()->json($this->model->withTrashed()->findOrFail($id)->restore());
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return void
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        try {
            parent::validate($request, $rules, $messages, $customAttributes);
        } catch (ValidationException $e) {
            logger($e->getMessage());
            return $e->getMessage();
        }
    }
}
