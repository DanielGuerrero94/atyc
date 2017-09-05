<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedisController extends Controller
{
    public function usuarios(Request $r)
    {
        return session()->all();
    }
}
