<?php

namespace App;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DNSSEC extends Model
{
    use SoftDeletes, Uuidable;

    protected $table = 'dnssec';

    protected $fillable = [
        'zone_id',
        'status',
        'algorithm',
        'bits',
        'dnskey',
        'ds1',
        'ds2',
        'ds3',
        'flags',
        'pdns_id',
        'keytype',
        'privatekey',
        'type',
    ];

    protected $hidden = [
        'pdns_id',
        'privatekey',
    ];

    public function zone (){
        return $this->belongsTo(Zone::class);
    }
}
