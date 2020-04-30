<?php

namespace App;

use App\Mail\NotificationAlert;
use App\Traits\Uuidable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;

class Notification extends Model
{
    use SoftDeletes, Uuidable;

    protected $fillable = [
        'user_id',
        'text',
        'seen',
        'type',
        'icon',
    ];

    protected $hidden = [
        'type',
        'icon',
    ];

    protected $casts = [
        'seen' => 'boolean',
    ];

    public static function boot(){
        parent::boot();

        static::created(function ($notification){
            if($notification->user->receive_notifications){
                Mail::to($notification->user->email)->queue(
                    new NotificationAlert($notification)
                );
            }
        });
    }

    public static function send($user, $type, $icon, $text){
        $notification['user_id'] = $user;
        $notification['type'] = $type;
        $notification['icon'] = $icon;
        $notification['text'] = $text;
        Notification::create($notification);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
