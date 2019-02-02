<?php 

namespace Rumi\Http\Controllers\Auth;


use Rumi\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class RoomerLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Roomer Login Controller
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
    protected $redirectTo = 'roomer.dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

	public function login()
    {
        return view('roomer.auth.login');
    }

    public function __construct()
    {
        $this->middleware('guest:roomer')->except('logout');
    }

    public function loginRoomer(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);
      // Attempt to log the user in
      if (Auth::guard('roomer')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

        // if successful, then redirect to their intended location
        return redirect()->intended(route('roomer.dashboard'));
      }
      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('email', 'remember'));
    }


    public function logout()
    {
        Auth::guard('roomer')->logout();
        return redirect()->route('roomer.auth.login');
    }
}
