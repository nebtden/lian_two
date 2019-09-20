<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;

class User extends Authenticatable
{
    // table name
    public $parent_user = [];

    protected $table = 'users';

    protected $fillable = [
        'name', 'phone', 'password','parent_id','ip','remark','type','status','parent_id','top_parent_id'
    ];

    public static  $status =[
        1=>'正常',
        0=>'关闭',
    ];

    public static  $type =[
        1=>'普通渠道商',  //高级经销商发展而来，可以邀请用户注册，也可以添加添加
        2=>'老客户',      //不属于任何经销商、后台系统导入，功能同普通经销商
        3=>'高级渠道商',  //比普通经销商多了个邀请注册，可以发展下级
        4=>'外拓经理',    //最顶级的经销商，具有所有功能
    ];

    public function showStatus($id){
        return self::$status[$id];
    }

    public function top(){
        return $this->belongsTo(User::class,'top_parent_id');
    }

    public function parent(){
        return $this->belongsTo(User::class,'parent_id');
    }

    public function client(){
        return $this->hasMany(Client::class,'user_id');
    }

    public static function get_child($users,$is_hide=0){
        if($users){
            foreach ($users as &$user){
                if($is_hide){
                    $children = User::where(['parent_id'=>$user->id,'status'=>1])->select('id',DB::raw("CONCAT(name,'-',LEFT(phone,9),'**-',case when type=1 then '普通渠道商' when type=2 then '老客户' when type=3 then '高级渠道商' when type=4 then '外拓经理' else '未知' end) as text"))->get();
                }else{
                    $children = User::where(['parent_id'=>$user->id,'status'=>1])->select('id',DB::raw("CONCAT(name,'-',phone,'-',case when type=1 then '普通渠道商' when type=2 then '老客户' when type=3 then '高级渠道商' when type=4 then '外拓经理' else '未知' end) as text"))->get();
                }
                if($children){
                    $children = self::get_child($children,$is_hide);
                    $user['nodes'] = $children;
                }
            }
        }
        return $users;
    }

    public function get_parent($user){
//        $user = User::where(['id'=>$id])->select('id','name')->get();
//        $this->html = $this->html . '->' . $user->name;
        $this->parent_user[] =$user;
        if($user->parent_id){
            $parent = User::where(['id'=>$user->parent_id])->select('id','name','parent_id')->first();
            if($parent){
                 $this->get_parent($parent);
            }else{
                $this->parent_user[] =$parent;
            }
        }


    }

    public function get_parent_html(){
        $html = '';
        $list = $this->parent_user;
        foreach ($list as $key=>$value){
            $a = "<a href='/admin/user/".$value->id."'>".$value->name."</a>";
            if($key==0 ){
                $html =  $a;
            }else{

                $html = $html.'->'.$a;
            }

        }
        return $html;
    }

    public static function  generateImage($user_id){
        $invitation_register = env('APP_URL').'/register?invitation='.$user_id;
        $qrCode = new QrCode($invitation_register);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);
        $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH));
        $qrCode->setLabel('渠道商注册二维码', 16);
        $qrCode->writeFile(storage_path('app/public/images/register_').$user_id.'.png');
        $register_image =  '/storage/images/register_'.$user_id.'.png';

        //邀请客户自己填写信息
        $client_add_self = env('APP_URL').'/client/self?invitation='.$user_id;
        $qrCode = new QrCode($client_add_self);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);
        $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH));
        $qrCode->setLabel('意向客户二维码', 16);
        $qrCode->writeFile(storage_path('app/public/images/self_').$user_id.'.png');
        $client_self_image =  '/storage/images/self_'.$user_id.'.png';

        $user = User::find($user_id);
        $user->invitaion_client_image = $client_self_image;
        $user->invitaion_register_image = $register_image;
        $user->save();
    }




}
