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
        $where[] =['clients_users.user_id','=',$user_id];
        $where[] =['clients_users.status','>',0];
//        $where[] =['clients_users.status','>',0];
        $where[] =['clients.is_rule_stopped','=',0];

//        >leftJoin('posts', 'users.id', '=', 'posts.user_id')
        $clients =  ClientUser::where(
            $where
        )->leftJoin('clients','clients_users.client_id','=','clients.id')->with('client')->orderBy('clients_users.id','desc')->paginate(7);

        $total = ClientUser::where(
            $where
        )->leftJoin('clients','clients_users.client_id','=','clients.id')->count();
        $status = ClientUser::$status;


        return view('client.index',[
            'clients'=>$clients,
            'status'=>$status,
            'total'=>$total,
        ]);
    }

    public function edit($id){
        //用户列表
        $where = [];
        $user_id = Auth::user()->id;
        $where['user_id'] = $user_id;
        $where['id'] = $id;
        $client =  ClientUser::where(
            $where
        )->first();

        return view('client.edit',[
            'client'=>$client,
            'statuses'=>ClientUser::$status,
        ]);
    }


    public function complain(Request $request,$id){
        $user_id = Auth::user()->id;
        $where = [];

        $where['user_id'] = $user_id;
        $where['id'] = $id;
        $client =  ClientUser::where(
            $where
        )->first();
        //系统更新
        if($request->post()){
            $file = $request->file('complain_file')->store('complain');
            $client->complain_file = $file;
            $client->complain_remark = $request->post('complain_remark');
            $client->complain_time = date('Y-m-d H:i:s',time());
            $client->save();

        }else{
            //用户列表

            $client =  ClientUser::where(
                $where
            )->first();

            return view('client.complain',[
                'client'=>$client,
                'statuses'=>ClientUser::$complain_status,
            ]);
        }

    }

    public function update(Request $request){

        $id = $request->get('id');
        $client = ClientUser::findOrFail($id);

        $client->status = $request->input('status');
        $client->remark = $request->input('remark');
        $client->save();
        $id = $client->id;
        $request->session()->flash('setting_status', '您的数据已更新');

        return   redirect('/user/client/');
    }




    public function accept(Request $request){
        $return = [
            'status'=>1,
            'data'=>[],
        ];

        $id = $request->get('id');

        //更新时间

        $client_user =  ClientUser::findOrFail($id);
        if($client_user){
            //更新接收时间
            $client_user->status = 1;
            $client_user->accept_at = date('Y-m-d H:i:s',time());
            $client_user->save();

            $client = Client::find($client_user->client_id);

            $return['phone']=$client->phone;

            //返回手机信息
        }else{
            $return['status']=0;
        }
        return response()->json($return);

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
