<?php

use \App\Services\Import\Providers\Cloudflare\CloudflareProvider;
use \App\Services\Import\Providers\DnsManagerIO\DnsManagerIOProvider;

return [
    'powerdns' => [
        'host' => env('DOMEINDNS_POWERDNS_HOST'),
        'api_key' => env('DOMEINDNS_POWERDNS_KEY'),
    ],
    'dns' => [
        'types' => ['A','AAAA','ALIAS','CAA','CNAME','MX','NS','SSHFP', 'SPF','SRV','TLSA','SMIMEA','TXT','URI'],
    ],
    'bootstrap' => [
        'types' => ['primary','success','info','warning','danger'],
    ],
    'forbidden_domains' => [
        'domeindns.nl',
    ],
];


