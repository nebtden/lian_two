<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string',  'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);
    }

    public function showRegistrationForm(Request $request)
    {
        $settings = Setting::all()->pluck('value','key');

        $invitation = $request->get('invitation');
        if($invitation){
            session(['invitation' => $invitation]);
        }
        return view('auth.register',[
            'settings'=>$settings,
        ]);
    }

    public function register(Request $request)
    {


        $data = $request->all();

        $phone = $data['phone'];
        $code = $data['code'];
        $key = $phone.'_code';
        $value = session()->get($key);
        if($value!=$code){
            $error = new MessageBag([
                'code'=>'验证码不正确'
            ]);
            return  back()->withInput()->withErrors($error);
        }

        $this->validator($request->all())->validate();


        //邀请码
        $invitation = session('invitation');
        $parent_id = 0;
        $top_parent_id = 0;
        $status = 0;
        $parent =[];
        if($invitation){
            $parent = User::where([
                'id'=>$invitation
            ])->first();
            if($parent){
                $parent_id = $parent->id;
                $top_parent_id = $parent->top_parent_id??$parent->id;
                $status = 1;
            }
        }

        $ip = $request->ip();


        $user = User::create([
            'phone' => $data['phone'],
            'name' => $data['name'],
//            'ip' => request()->ip(),
            'password' => Hash::make($data['password']),
            'parent_id' => $parent_id,
            'status' => $status,
            'ip' => $ip,
            'top_parent_id' => $top_parent_id,
        ]);

        User::generateImage($user->id);

        if(!$parent){
            session()->flash('setting_status', '恭喜您注册功能，请等待管理员审核之后，才可使用此系统');
//            return  back()->withInput();
        }


        //检查是否存在未注册时绑定的用户，且用户为0
        $client = Client::where([
            'provider_phone'=>$data['phone'],
            'user_id'=>0,
        ])->first();

        //登录系统
        if($client){
            Client::where([
                'provider_phone'=>$data['phone'],
                'user_id'=>0,
            ])->update(['user_id' => $user->id,'top_parent_id' => $top_parent_id,]);
        }

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //监测验证码是否正确
        $phone = $data['phone'];
        $code = $data['code'];
        $key = $phone.'_code';
        $value = session()->get($key);
        if($value!=$code){
            $error = new MessageBag([
                'code'=>'验证码不正确'
            ]);
            return  back()->withInput()->withErrors($error);
        }



        //邀请码
        $invitation = session('invitation');
        $parent_id = 0;
        $top_parent_id = 0;
        $status = 0;
        $parent =[];
        if($invitation){
            $parent = User::where([
                'id'=>$invitation
            ])->first();
            if($parent){
                $parent_id = $parent->id;
                $top_parent_id = $parent->top_parent_id??$parent->id;
                $status = 1;
            }
        }


        $user = User::create([
            'phone' => $data['phone'],
            'name' => $data['name'],
//            'ip' => request()->ip(),
            'password' => Hash::make($data['password']),
            'parent_id' => $parent_id,
            'status' => $status,
            'top_parent_id' => $top_parent_id,
        ]);

        User::generateImage($user->id);

        if(!$parent){
            session()->flash('setting_status', '恭喜您注册功能，请等待管理员审核之后，才可使用此系统');
//            return  back()->withInput();
        }


        //检查是否存在未注册时绑定的用户，且用户为0
        $client = Client::where([
            'provider_phone'=>$data['phone'],
            'user_id'=>0,
        ])->first();

        //登录系统
        if($client){
            Client::where([
                'provider_phone'=>$data['phone'],
                'user_id'=>0,
            ])->update(['user_id' => $user->id,'top_parent_id' => $top_parent_id,]);
        }



        return $user;
    }
}
