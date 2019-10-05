<?php

namespace App\Imports;

use App\Models\AdminUser;
use App\Models\Client;
use App\Models\User;
use Encore\Admin\Facades\Admin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $now_admin = Admin::user();
        $isAdmin = $now_admin ->isRole('administrator');

        if(!$row['phone']){
            return null;
        }


        $client = Client::where([
            'phone'=>$row['phone']
        ])->first();
        if($client){
            $phones = session()->get('client_phone');
            array_push($phones,$row['phone']);
            session(['client_phone' => $phones]);
//            session()->save();
             return null;
           throw  new \Exception($row['phone'].'已经在系统中，导入失败！');
        }
        if($isAdmin && isset($row['created_at']) and $row['created_at']){
            $created_at = substr($row['created_at'],0,4).
                '-'.substr($row['created_at'],4,2).
                '-'.substr($row['created_at'],6,2).' 00:00:00';

        }else{
            $created_at =  date('Y-m-d H:i:s');
        }

        $admin_user_id = 0;


//        $status = (int)$row['status'];
//        if(!in_array($status,[1,2,3,4,5])){
//            throw  new \Exception($row['status'].'状态不在系统中，导入失败！');
//        }

        $user_id = 0;
//        if(isset($row['user']) and $row['user']){
//            $user = User::where([
//                'phone'=>$row['user']
//            ])->first();
//            if($user){
//                $user_id = $user->id;
//            }else{
//                throw  new \Exception($row['user'].'渠道商不在系统中，导入失败！');
//            }
//        }

        $data = [
            'user_name'     => $row['name'],
            'phone'    => trim($row['phone']),
            'remark'    => $row['remark']??'',
            'admin_remark'    => $row['admin_remark']??'',
            'transfer_remark' => $row['transfer_remark']??'',
            'sales_remark'    => $row['sales_remark']??'',
//            'sales_status'    => $row['sales_status']??1,
//            'status'        => $status,
            'created_at'        => $created_at,
            'admin_user_id'     =>$now_admin->id,
            'upload_admin_id'   => $now_admin->id,

        ];


        return new Client($data);



    }

    public function headingRow(): int
    {
        return 2;
    }
}
