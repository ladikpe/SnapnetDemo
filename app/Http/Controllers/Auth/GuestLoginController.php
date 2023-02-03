<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class GuestLoginController extends Controller
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
    protected $redirectTo = '/vendor-home';  //upstream

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function attemptLogin(Request $request)
    {   
        $attempt=Auth::guard('vendor')->attempt( $this->credentials($request), $request->has('remember'));

//        if($attempt)
//        {
//            \App\ExternalUser::where('email', $request->email)->update(['last_login' => date('Y-m-d H:i:s')]);
//            $user = \App\ExternalUser::where('email', $request->email)->first();
//            // $user->user_login_history()->create(['last_login' => date('Y-m-d H:i:s')]);
//        }
 
        return $attempt;
    } 



    //PREVINTING DEACTIVATED USERS FROM LOGGIN 
     protected function credentials(\Illuminate\Http\Request $request)
     {
        $credentials = $request->only($this->email(), 'password');
        return array_add($credentials, 'active', '1');
     }


    /*public function authenticate()
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) 
        {
            // Authentication passed...
            return redirectTo();
        }
    }*/
}
