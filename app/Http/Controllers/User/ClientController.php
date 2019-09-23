<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\StoreClient;
use App\Imports\ClientsImport;
use App\Imports\UserClientsImport;
use App\Jobs\ProcessEmail;
use App\Models\Client;
use App\Models\ClientUser;
use App\Models\Setting;
use App\Models\User;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{

    public function index(){
        $user = Auth::user();

        //当刚注册的时候，现在审核信息
        if($user->status==0){
            return  view('abandon');
        }

        //用户列表
        $where = [];
        $user_id = Auth::user()->id;
        $where['user_id'] = $user_id;
        $clients =  ClientUser::where(
            $where
        )->with('client')->orderBy('id','desc')->paginate(7);
//        dd($clients);

        $total = ClientUser::where(
            $where
        )->count();
        $status = ClientUser::$status;
//        dd($status);


        return view('client.index',[
            'clients'=>$clients,
            'status'=>$status,
            'total'=>$total,
        ]);
    }




    public function update(Request $request){

        $id = $request->get('id');
        $client = Client::findOrFail($id);
        $user = Auth::user();

        $client->user_name = $request->input('user_name');
        $client->user_id = $user->id;
        $client->remark = $request->input('remark');
        $client->save();
        $id = $client->id;
        $request->session()->flash('setting_status', '您的数据已更新，
        感谢您的信任与支持!实现成交后，工作人员将联系您');

        return   redirect('/user/client/'.$id.'/edit');
    }

    public function upload(Request $request){

        return view('client.upload',[

        ]);
    }

    public function accept(Request $request){
        $id = $request->get('id');

        //更新时间

        $client =  Client::findOrFail($id);
        if($client){
            //更新接收时间
            $client->status = 1;

        }
        //return \Illuminate\Http\Response::wi
    }

    public function saveFive(Request $request){
        session(['client_phone' => []]);
//

        Excel::import(new UserClientsImport, $request->file('file'));
        $message = '客户导入成功！';
        $phones = session()->get('client_phone');
        if($phones){
            $phones = implode(',',$phones);
            $message = $message.'重复电话号码有：'.$phones;
        }

        $request->session()->flash('setting_status', $message);

         return   redirect('/user/client/');
    }



    public function edit($id){
        //用户列表
        $where = [];
        $user_id = Auth::user()->id;
        $where['user_id'] = $user_id;
        $where['id'] = $id;
        $client =  Client::where(
            $where
        )->first();

        return view('client.edit',[
            'client'=>$client,
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

        return view('client.index',[
            'client'=>$client,
        ]);
    }


    public function create(Request $request){

//        ProcessPodcast::dispatch($podcast)
        $settings = Setting::all()->pluck('value','key');

        return view('client.create',[
            'notice'=>$settings['notice'],
        ]);
    }
}
