<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RulesDetail extends Model
{
    // table name
    protected $table = 'rules_detail';

    protected $fillable = [
        'time_last', 'rule_id',  'index','user_id'
    ];

    public function Rule(){
        return $this->belongsTo(Rule::class);
    }


}
