<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // table name
    protected $table = 'clients';

    protected $fillable = [
        'user_name', 'phone',  'status','created_at','remark','admin_user_id','user_id','upload_admin_id',
        'transfer_remark','admin_remark','sales_remark','sales_status'
    ];

    public static  $status =[
        1=>'跟踪中',
        2=>'失效',
        3=>'初步订单完成，正在走成交流程',
        4=>'客户财务完成',
        5=>'销售完成',
    ];


    public static $sales_status = [
        0=>'跟踪中',
        -1=>'失效',
        -2=>'战败',
        1=>'初步订单',
        2=>'订单完成',
    ];


    public function  rules(){

        return [
            'phone' => 'required|unique:clients|regex:/^1\d{10}$/i|numeric',
            'user_name' => 'required',
        ];
    }


    public function admin(){
        return $this->belongsTo(AdminUser::class,'admin_user_id');
    }

    public function upload(){
        return $this->belongsTo(AdminUser::class,'upload_admin_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function top(){
        return $this->belongsTo(User::class,'top_parent_id');
    }


    public static function mailText($name,$phone,$user_name,$user_phone,$is_repeat){
        if($is_repeat){
            $object = "您好，有新的渠道商提交了数据，数据重复，请协助检查<br>";
        }else{
            $object = "您好，有新的渠道商提交了数据，数据未重复，请立即联系<br>";
        }

        $object = $object."客户姓名为".$name."<br>";
        $object = $object."客户电话号码为".$phone."<br>";

        $object = $object."提交的渠道商为".$user_name."<br>";
//        $object = $object."提交的渠道商电话号码为".$user_phone."<br>";

        return $object;

    }



}
