<?php

namespace App;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZoneTag extends Model
{
    use SoftDeletes, Uuidable;

    protected $fillable = [
        'zone_id',
        'tag_id',
    ];
}
