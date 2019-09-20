<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = '/home';

    public function username()
    {
        return 'phone';
    }



    public function showLoginForm()
    {
        $settings = Setting::all()->pluck('value','key');

        return view('auth.login',[
            'settings'=>$settings,
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        $phone = $request->get('phone');
        $password = $request->get('password');
        return ['phone' => $phone, 'password' => $password];
    }

    function authenticated(Request $request, $user)
    {
        $user->ip = $request->ip();
        $user->save();
    }

}
