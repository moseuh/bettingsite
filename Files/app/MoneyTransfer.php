<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyTransfer extends Model
{
    protected $table = "money_transfers";

    protected $guarded = [];


    public function transferTo()
    {
        return  $this->belongsTo('App\User','receiver_id','id');
    }
    public function transferForm()
    {
    	return  $this->belongsTo('App\User','sender_id','id');
    }



       protected $dates = [
    	'send_at',
        'created_at',
        'updated_at'
    ];

}
