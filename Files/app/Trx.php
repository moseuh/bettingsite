<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trx extends Model
{
    protected $guarded = [];


    public  function user()
    {
    	return $this->belongTo('App\User','user_id','id');
    }
}
