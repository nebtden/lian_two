<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.phone');
    }

    public function phone(Request $request){

            //检测验证码是否正确
            $phone = $request->get('phone');
            $code = $request->get('code');
            $password = $request->get('password');
            $password_confirmation = $request->get('password_confirmation');
            $key = $phone.'_code';
            $value = $request->session()->get($key);
            if($value!=$code){
//                throw new \Exception('验证码不正确');
                $error = new MessageBag([
                    'code'=>'验证码不正确'
                ]);
                return  back()->withInput()->withErrors($error);
            }

            if($password!=$password_confirmation){
//                throw new \Exception('两次密码不一致');
                $error = new MessageBag([
                    'password'=>'两次密码不一致'
                ]);
                return  back()->withInput()->withErrors($error);
            }
            //检测密码是否一致
            //修改密码
            User::where([
                'phone'=>$phone
            ])->update([
                'password'=>Hash::make($password)
            ]);

        return redirect()->route('login');



    }
}
