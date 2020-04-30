@component('mail::message')
# New Notification

There is a new notification for your account:
> *{{ $notification->text }}*

@component('mail::button', ['url' => url('/')])
    Visit dashboard
@endcomponent

Kind regards,<br>
{{ config('app.name') }}
@endcomponent
