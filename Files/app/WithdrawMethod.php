<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawMethod extends Model
{

    protected $guarded = ['id'];
    protected $table = 'withdraw_methods';

    protected $casts = [
        'input_form' => 'object',
    ];


}
