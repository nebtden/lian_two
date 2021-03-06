<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    // table name
    protected $table = 'rules';

    public function detail(){
        return $this->hasMany(RulesDetail::class,'rule_id');
    }

}
