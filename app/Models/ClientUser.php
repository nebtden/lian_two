<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientUser extends Model
{
    // table name
    protected $table = 'clients_users';

    protected $fillable = [
        'client_id', 'user_id','status',
    ];

    //在列表页里面控制，临时停止
    public static $is_open = [
        1=>'开启',
        0=>'关闭',
    ];

    public static $status = [
        -2=>'策略停止', //永久停止
        -1=>'数据没生效',
        0=>'数据刚分配',
        1=>'成交完成（核心业务）',
        2=> '成交完成（基础业务）',
        3=>'订单（核心业务） ',
        4=>'订单（基础业务）',
        5=>'战败同行',
        6=>'数据已失效',
        7=>'订单退单',
        8=>'数据冲突 ',
    ];

    public static $sales_status = [
        0=>'跟踪中',
        -1=>'失效',
        -2=>'战败',
        1=>'初步订单',
        2=>'订单完成',
    ];

    public  static $complain_status = [
        0=>'未申诉',
        1=>'开始申诉',
        2=>'申诉完成',
    ];

    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }



}
