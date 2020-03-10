<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $maxAttempts = 3;

    protected $decayMinutes = 5;

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
        $username = $request->post('username');
        $user = User::where('username', $username)
            ->orWhere('email', $username)
            ->first();
        if (!$user) {
            return false;
        }
        
        if (!Hash::check($request->post('password'), $user->password)) {
            return false;
        }

        Auth::login($user);
        return true;
    }

    public function username()
    {
        return 'username';
    }

    public function redirectTo()
    {
        if (Auth::user()->type == 'user') {
            return $this->redirectTo;
        }
        return route('categories');
    }
}
