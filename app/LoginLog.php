<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoginLog extends Model
{
    protected $table = 'login_log';

    protected $fillable = [
        'user_id',
        'ip',
        'useragent',
    ];

    protected $hidden = [
        'id',
    ];
}
