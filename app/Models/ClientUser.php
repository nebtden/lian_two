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
        1=>'test1',
        2=>'test2',
        3=>'test3',
    ];

    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }




}
