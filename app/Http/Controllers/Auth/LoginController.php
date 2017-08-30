<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
/*Lo agrego para hacer pruebas*/
use Log;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Log::debug(json_encode(Auth::user()));
        Log::debug(json_encode(request()->ip()));
        $this->middleware('guest', ['except' => 'logout']);
    }

    //Sobrecargo estos dos metodos que traigo desde el trait AuthenticatesUsers

     /**
      * Get the login username to be used by the controller.
      *
      * @return string
      */
    public function username()
    {
        return 'name';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $request['name'] = strtolower($request->name);
        return $request->only($this->username(), 'password');
    }
}
