<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposits';
    protected $guarded = ['id'];

    protected $casts = [
        'detail' => 'object'
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // scope
    public function scopeGateway_currency()
    {
        return GatewayCurrency::where('method_code', $this->method_code)->where('currency', $this->method_currency)->first();
    }

    public function scopeBaseCurrency()
    {
        return $this->gateway->crypto == 1 ? 'USD' : $this->method_currency;
    }


    public function myGatewayCurrency()
    {
        return $this->belongsTo('App\GatewayCurrency','method_code','method_code');
    }



}
