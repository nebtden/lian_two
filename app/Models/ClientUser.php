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







}
