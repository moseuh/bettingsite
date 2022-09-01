<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawLog extends Model
{
    protected $table = 'withdraw_logs';

    protected $guarded = ['id'];
    protected $casts = [
        'withdraw_information' => 'object'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }

    public function method()
    {
        return $this->belongsTo('App\WithdrawMethod', 'method_id','id');
    }

}
