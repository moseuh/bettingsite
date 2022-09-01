<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    protected $table = "events";

    public  function  inplayes()
    {
        return $this->hasMany('App\Match')->whereStatus(1)->latest()->limit(5);
    }
    public  function  matches()
    {
        return $this->hasMany('App\Match');
    }

}
