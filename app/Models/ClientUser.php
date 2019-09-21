<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientUser extends Model
{
    // table name
    protected $table = 'clients_uses';

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




}
