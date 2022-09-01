<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BetQuestion extends Model
{
    use SoftDeletes;
    protected $table = "bet_questions";

    protected $guarded = [];

    public function options()
    {
        return $this->hasMany('App\BetOption','question_id');
    }

    public function invests()
    {
        return $this->hasMany('App\BetInvest','betquestion_id');
    }


    public function match()
    {
        return $this->belongsTo('App\Match','match_id');
    }

    public function scopeTotalInvest()
    {
        return $this->hasMany('App\BetInvest','betquestion_id')->where('status','!=',2)->count();
    }




    public function scopeTotalInvestor()
    {
        return $this->invests()->count();
    }

}
