<?php

namespace App\Http\Controllers\Auth;

use App\Classes\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function login(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
            'g-recaptcha-response' => ['required', new RecaptchaRule()]
        ]);

        if(auth()->attempt(array('email' => $input['email'], 'password' => ($input['password'])))) {
            $user = Auth::user();
            if ($user->hasRole(UserTypesEnum::SuperAdmin)) {
                return redirect()->route('super-admin.dashboard');
            } elseif ($user->hasRole(UserTypesEnum::User)) {
                return redirect()->route('user.dashboard');
            } else {
                return redirect()->route('login')
                    ->withErrors(['error' => 'Incorrect username or password'])
                    ->withInput($request->session()->put('data', $request->input()));
            }
//            $user = Auth::user();
            return redirect(Auth::user()->user_type.RouteServiceProvider::DASHBOARD);

//            switch ($user->user_type) {
//                case UserTypesEnum::SuperAdmin:
//                    return redirect()->route('super-admin.dashboard');
//                case UserTypesEnum::User:
//                    return redirect()->route('user.dashboard');
//                default:
//                    return redirect()->route('login')
//                        ->withErrors(['error' => 'Incorrect username or password'])
//                        ->withInput($request->session()->put('data', $request->input()));
//            }

//            if ($user->hasRole(UserTypesEnum::SuperAdmin)) {
//                return redirect()->route('super-admin.dashboard');
//            } elseif ($user->hasRole(UserTypesEnum::User)) {
//                return redirect()->route('user.dashboard');
//            } else {
//                return redirect()->route('login')
//                    ->withErrors(['error' => 'Incorrect username or password'])
//                    ->withInput($request->session()->put('data', $request->input()));
//            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('login');
    }
}
