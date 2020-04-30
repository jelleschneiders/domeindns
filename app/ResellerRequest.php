<?php

namespace App;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Model;

class ResellerRequest extends Model
{
    use Uuidable;

    protected $fillable = [
        'user_id',
        'reason',
        'handled',
    ];

    protected $casts = [
        'handled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
