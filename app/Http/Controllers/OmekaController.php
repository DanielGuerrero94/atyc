<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OmekaController extends Controller
{
    public function iframe()
    {
        return view('omeka');
    }
}
