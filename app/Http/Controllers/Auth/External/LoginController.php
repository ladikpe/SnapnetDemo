<?php
namespace App\Http\Controllers\Auth\External;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
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

    protected $redirectTo = '/vendor-home';


     public function __construct()
     {
         $this->middleware('auth:vendor')->except(['loginExternal', 'login', 'logout']);
     }

     
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function login()
      {
          return view('auth.vendor-login');
      }

      public function loginExternal(Request $request)
      {
        // return $request->all();
        // Validate the form data
        $this->validate($request, [
          'email'   => 'required|email',
          'password' => 'required|min:5'
        ]);
        // Attempt to log the user in
        if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))
        {
          // if successful, then redirect to their intended location
          return redirect()->route('vendor-home');
        }
        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
      }
      
      public function logout_vendor()
      {
          Auth::guard('vendor')->logout();
          return redirect()->route('external.auth.login');
      }
}