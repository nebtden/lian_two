<?php

namespace App\Logic;
/*
 *
 *李安系统更新手机号码
 * */

class Lian{

    public static function HidePhone($phone){
        return   substr($phone,0,9).'**';
    }

    public static function HandleClientPhone($client){
        if(!$client->accept_at){
            return self::HidePhone($client->client->phone);
        }else{
            return $client->client->phone;
        }
    }
}
