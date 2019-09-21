<?php

namespace App\Http\Controllers\User;

use App\Models\Client;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class SettingController extends Controller
{

    /**
     * Show the index
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        //当刚注册的时候，现在审核信息
        if($user->status==0){
            return  view('abandon');
        }
        $invitation = env('APP_URL').'/register?id='.$user->id;
        if($request->post()){

            $user->bank_name = $request->input('bank_name')??'';
            $user->name = $request->input('name')??'';
            $user->card_number = $request->input('card_number')??'';
            $password = $request->input('password')??'';
            $password_confirmation = $request->input('password_confirmation')??'';
            if($password){
                if($password == $password_confirmation){
                    $user->password = Hash::make($password);
                }else{
                    $error = new MessageBag([
                        'password'=>'两次密码不一致！'
                    ]);

                    return  back()->withInput()->withErrors($error);
                }

            }
            $user->save();
            $request->session()->flash('setting_status', '更新成功!');

        }
        $settings = Setting::all()->pluck('value','key');
        if($user->type==1 or $user->type==3 && $user->top_parent_id){
            $top = User::find($user->top_parent_id);
        }else{
            $top = [];
        }

        return view('user.setting',[
            'user'=>$user,
            'invitation'=>$invitation,
            'settings'=>$settings,
            'top'=>$top,

        ]);
    }

    public function show($id){
        //用户列表
        $where = [];
        $user_id = Auth::user()->id;
        $where['user_id'] = $user_id;
        $where['id'] = $id;
        $client =  Client::where(
            $where
        )->first();


        return view('user.index',[
            'client'=>$client,
        ]);
    }
}
