<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BetInvest extends Model
{
    use  SoftDeletes;
    protected $guarded = [];
    protected $table = "bet_invests";

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function match()
    {
        return $this->belongsTo('App\Match','match_id','id');
    }
    public function ques()
    {
        return $this->belongsTo('App\BetQuestion','betquestion_id','id');
    }
    public function betoption()
    {
        return $this->belongsTo('App\BetOption','betoption_id','id');
    }

}
