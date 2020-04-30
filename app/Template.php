<?php

namespace App;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use SoftDeletes, Uuidable;

    protected $fillable = [
        'user_id',
        'name',
    ];

    public function records()
    {
        return $this->hasMany(TemplateRecord::class);
    }

    public function insertDefaultRecords()
    {
        $nameservers = auth()->user()->nameservers()->get();

        if($nameservers->count() == 0){
            $nameservers = Nameserver::where('default', true)->get();
        }

        foreach ($nameservers as $nameserver){
            $this->records()->create([
                'record_type' => 'NS',
                'ttl' => 3600,
                'content' => $nameserver->nameserver.'.',
                'status' => Status::$OK
            ]);
        }
    }
}
