<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GatewayCurrency extends Model
{
    protected $casts = ['status' => 'boolean', 'extra' => 'object','input_form'=>'object'];
    protected $guarded = ['id'];
    protected $table = "payment_gateway";

    public function currencyIdentifier()
    {
        return $this->name ?? $this->method->name . ' ' . $this->currency;
    }


    public function scopeBaseCurrency()
    {
        return $this->method->crypto == 1 ? 'USD' : $this->currency;
    }

    public function scopeAutomatic()
    {
        return $this->where('method_code', '<', 1000);
    }

    public function scopeManual()
    {
        return $this->where('method_code', '>=', 1000);
    }




}
