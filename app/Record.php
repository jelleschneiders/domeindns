<?php

namespace App;

use App\Jobs\CreateRecord;
use App\Jobs\DeleteRecord;
use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use SoftDeletes, Uuidable;

    protected $fillable = [
        'zone_id',
        'record_type',
        'ttl',
        'name',
        'content',
        'status',
        'failed_reason',
    ];

    public static function create_new($zone, $type, $ttl, $name, $content){
        $attribute['zone_id'] = $zone;
        $attribute['record_type'] = $type;
        $attribute['ttl'] = $ttl;
        $attribute['name'] = $name;
        $attribute['content'] = $content;

        $record = Record::create($attribute);
        CreateRecord::dispatch($record);

        return $record;
    }

    public function zone (){
        return $this->belongsTo(Zone::class);
    }

    public function formatRecord($disabled = false)
    {
        return [
            'content' => $this->content,
            'disabled' => $disabled,
        ];
    }
    public function formatName(): string
    {
        return (empty($this->name) ? null : $this->name . '.') . $this->zone->domain . '.';
    }
}
