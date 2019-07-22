<?php

namespace App\Http\Controllers\Auth;

use App\ActivityPoint;
use App\Alerts;
use App\Objective;
use App\sweetcaptcha;
use App\Task;
use App\Unit;
use App\User;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers as AuthenticatesUsers;
use App\SiteActivity;
use Hashids\Hashids;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesUsers, RegistersUsers {
        AuthenticatesUsers::redirectPath insteadof RegistersUsers;
        AuthenticatesUsers::guard insteadof RegistersUsers;
    }


    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Where user redirect after successfully logout
     */
    protected $redirectAfterLogout = '/login';
    
    public $sweetcaptcha;

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        view()->share('user_login',\Auth::check());
        $this->sweetcaptcha =new  sweetcaptcha(
            env('SWEETCAPTCHA_APP_ID'),
            env('SWEETCAPTCHA_KEY'),
            env('SWEETCAPTCHA_SECRET'),
            public_path('sweetcaptcha.php')
        );
        $this->middleware('guest')->except('Logout');

    }

    /**
     * Method will called after login successfully into system
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticated( \Illuminate\Http\Request $request, \App\User $user ) {
        return redirect()->intended($this->redirectPath());
    }

    //Login via Username and Email Address.
    public function login(Request $request)
    {
        $validator = Validator::make(\Request::all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        $field = filter_var(\Request::input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        \Request::merge([$field => \Request::input('email')]);

        if (\Auth::attempt(\Request::only($field, 'password'))){
            // dd($field);
            return redirect()->intended('/');
        }


        return redirect('/login')->withErrors([
            'error' => 'These credentials do not match our records.',
        ]);
    }

}
