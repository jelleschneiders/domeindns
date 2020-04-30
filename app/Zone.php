<?php

namespace App;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use SoftDeletes, Uuidable;

    protected $casts = [
        'dnssec' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'domain',
        'dnssec',
        'status',
        'failed_reason',
    ];

    public function records (){
        return $this->hasMany(Record::class);
    }

    public function dns_sec (){
        return $this->hasOne(DNSSEC::class);
    }

    public function tags()
    {
        return $this->hasMany(ZoneTag::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
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

    public function checkExistingRecord($type, $name, $content)
    {
        $checkexisting = Record::where([
            ['zone_id', $this->id],
            ['record_type', $type],
            ['name', $name],
            ['content', $content]
        ]);

        if($checkexisting->count() != 0){
            $exists = true;
        }else{
            $exists = false;
        }

        return $exists;
    }

    public function insertGoogleMXRecords(){
        $this->records()->create([
            'record_type' => 'MX',
            'ttl' => 3600,
            'content' => '1 aspmx.l.google.com.',
            'status' => Status::$OK
        ]);
        $this->records()->create([
            'record_type' => 'MX',
            'ttl' => 3600,
            'content' => '5 alt1.aspmx.l.google.com.',
            'status' => Status::$OK
        ]);
        $this->records()->create([
            'record_type' => 'MX',
            'ttl' => 3600,
            'content' => '5 alt2.aspmx.l.google.com.',
            'status' => Status::$OK
        ]);
        $this->records()->create([
            'record_type' => 'MX',
            'ttl' => 3600,
            'content' => '10 alt3.aspmx.l.google.com.',
            'status' => Status::$OK
        ]);
        $record = $this->records()->create([
            'record_type' => 'MX',
            'ttl' => 3600,
            'content' => '10 alt4.aspmx.l.google.com.'
        ]);
        \App\Jobs\CreateRecord::dispatch($record);
    }
}
