<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provincia;
use Log;

class provinciasController extends Controller
{

	public function getAll()		
	{
		return Provincia::all();
	}

	public function get(Request $request)
	{
		return Provincia::findOrFail($request->id);
	}

	public function set(Request $request)
	{
		Provincia::set($request->nombre);
		return redirect('dashboard');
	}
    
}
