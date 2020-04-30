<?php

namespace App;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateRecord extends Model
{
    use SoftDeletes, Uuidable;

    protected $fillable = [
        'template_id',
        'record_type',
        'ttl',
        'name',
        'content',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
