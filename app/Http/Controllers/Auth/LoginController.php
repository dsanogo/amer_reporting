<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use Authenticatable;
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

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|min:1'
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('login')->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

            $user = User::where('Username', $request->username)->where('Password', $request->password)->first();

            if ($user && $user->UserRoleId == 6) {
                Auth::login($user, false);
                Session::put('user', $user);
                
                return redirect()->intended($this->redirectTo);
            } elseif ($user && $user->UserRolId !== 6) return redirect()->back()->withInput($request->only('email', 'password'))->withErrors(['role' => 'You are not authorized to access the reports. Please check with your Administrator']);

            return redirect()->back()->withInput($request->only('email', 'password'))->withErrors(['username' => 'Username or password incorrect']);
        }
    }

    public function logout()
    {
        Session::forget('user');
        return Redirect::to('login');
    }
}
