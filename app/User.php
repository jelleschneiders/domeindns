<?php

namespace App;

use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\PersonalDataExport\ExportsPersonalData;
use Spatie\PersonalDataExport\PersonalDataSelection;

class User extends Authenticatable implements MustVerifyEmail, ExportsPersonalData
{
    use SoftDeletes, Notifiable, Uuidable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'managed_by',
        'name',
        'email',
        'password',
        'api_token',
        'totp_token',
        'allow_totp_recovery',
        'allow_support',
        'receive_notifications',
        'dangerzone',
        'allow_transfers',
        'reseller',
        'is_blocked',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'totp_token',
        'api_token',
        'remember_token',
        'is_admin',
        'is_blocked',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'totp_status' => 'boolean',
        'allow_totp_recovery' => 'boolean',
        'allow_support' => 'boolean',
        'receive_notifications' => 'boolean',
        'dangerzone' => 'boolean',
        'allow_transfers' => 'boolean',
        'reseller' => 'boolean',
        'is_admin' => 'boolean',
        'is_blocked' => 'boolean',
    ];

    public function zones() {
        return $this->hasMany(Zone::class);
    }

    public function templates()
    {
        return $this->hasMany(Template::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function loginlogs()
    {
        return $this->hasMany(LoginLog::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function dataexports()
    {
        return $this->hasMany(Dataexport::class);
    }

    public function reseller_requests()
    {
        return $this->hasMany(ResellerRequest::class);
    }

    public function nameservers()
    {
        return $this->hasMany(Nameserver::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function selectPersonalData(PersonalDataSelection $personalData): void {
        $personalData->add('user.json', $this);
        $personalData->add('tags.json', $this->tags()->withTrashed()->get());
        $personalData->add('login_logs.json', $this->loginlogs()->get());
        $personalData->add('reseller_requests.json', $this->reseller_requests()->get());
        $personalData->add('notifications.json', $this->notifications()->withTrashed()->get());
        $personalData->add('data_exports.json', $this->dataexports()->get());
        $personalData->add('nameservers.json', $this->nameservers()->withTrashed()->get());
        $personalData->add('transfers.json', $this->transfers()->get());

        $personalData->add('zones.json', $this->zones()->withTrashed()->get());
        foreach ($this->zones()->withTrashed()->get() as $zone){
            $personalData->add('zones/'.$zone->id.'/records.json', $zone->records()->withTrashed()->get());
            $personalData->add('zones/'.$zone->id.'/dnssec.json', $zone->dns_sec()->withTrashed()->get());
            $personalData->add('zones/'.$zone->id.'/tags.json', $zone->tags()->withTrashed()->get());
        }

        $personalData->add('templates.json', $this->templates()->withTrashed()->get());
        foreach ($this->templates()->withTrashed()->get() as $template){
            $personalData->add('templates/'.$template->id.'/records.json', $template->records()->withTrashed()->get());
        }
    }

    public function personalDataExportName(): string
    {
        $slug = \Str::slug($this->name);

        return "personal-data-{$slug}.zip";
    }
}
