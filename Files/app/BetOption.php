<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BetOption extends Model
{
    use SoftDeletes;
    protected $table = "bet_options";

    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo('App\BetQuestion','question_id','id');
    }
    public function invests()
    {
        return $this->hasMany('App\BetInvest', 'betoption_id');
    }




    public function match()
    {
        return $this->belongsTo('App\Match');
    }

    public function investTk()
    {
        return $this->hasMany('App\BetInvest', 'betoption_id')->where('status','!=',2)->sum('invest_amount');
    }

    public function giveBackTk()
    {
        return $this->hasMany('App\BetInvest', 'betoption_id')->where('status','!=',2)->sum('return_amount');
    }

    public function scopeTotalInvestByOptions()
    {
        return $this->hasMany('App\BetInvest','betoption_id')->where('status','!=',2)->count();
    }

}
