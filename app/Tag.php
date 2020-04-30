<?php

namespace App;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes, Uuidable;

    protected $fillable = [
        'user_id',
        'name',
    ];

    public function zones()
    {
        return $this->hasMany(ZoneTag::class);
    }
}
