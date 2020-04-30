<?php

namespace App;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use Uuidable;

    protected $fillable = [
        'user_id',
        'to',
        'zone_id',
        'status',
    ];

    public function domain()
    {
        return $this->hasOne(Zone::class, 'id', 'zone_id');
    }

    public function to_user()
    {
        return $this->hasOne(User::class, 'id', 'to');
    }

    public function from_user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
