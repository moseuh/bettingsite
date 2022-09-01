<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminLogin extends Model
{
    protected $table = "admin_logins";
    protected $guarded = ['id'];
}
