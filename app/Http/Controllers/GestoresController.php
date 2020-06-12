<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use Datatables;

class GestoresController extends Controller
{
    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|string',
        'title' => 'required|string'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gestores.gestores');
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $gestor = User::findOrFail($id);
            return ['gestor' => $gestor];
        } catch (ModelNotFoundException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('gestores/modificar', $this->show($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $error = $this->validate($request, $this->rules);

        if ($error) {
            return response($error, 400);
        }

        try {
            $user = User::findOrFail($id);
            return response()->json($user->update($request->all()));
        } catch (ModelNotFoundException $e) {
            return ['response' => response()->json(['success' => false, 'error' => $e->getMessage()])];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $r, $id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user->delete());
        } catch (ModelNotFoundException $e) {
            return ['response' => response()->json(['success' => false, 'error' => $e->getMessage()])];
        }
    }

    public function getTabla()
    {
        $query = User::select('id_user', 'name', 'email', 'title');
        return Datatables::of($query)
        ->addColumn(
            'acciones',
            function ($ret) {
                $buttons = '<a data-id="'.$ret->id_user.'" class="btn btn-circle editar" '.
                'title="Editar" style="margin-right: 1rem;"><i class="fa fa-pencil" aria-hidden="true" style="color: dodgerblue;"></i></a>'.
                '<a data-id="'.$ret->id_user.'" class="btn btn-circle eliminar" '.
                'title="Eliminar" style="margin-right: 1rem;"><i class="fa fa-trash" aria-hidden="true" style="color: dimgray;"></i></a>';

                return $buttons;
            }
        )->make(true);
    }
}
