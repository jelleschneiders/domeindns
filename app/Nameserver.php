<?php

namespace App;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nameserver extends Model
{
    use SoftDeletes, Uuidable;

    protected $fillable = [
        'user_id',
        'default',
        'nameserver',
        'ipv4',
        'ipv6',
    ];

    protected $casts = [
        'default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
