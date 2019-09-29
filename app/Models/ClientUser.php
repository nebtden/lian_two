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

    public static $status = [
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

    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }



}
