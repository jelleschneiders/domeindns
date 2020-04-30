@component('mail::message')
# Personal data download

You can now download a zip file containing all the data we have about you in JSON format.

Please don't share this link with anyone, it contains all of your data!

@component('mail::button', ['url' => route('personal-data-exports', $zipFilename)])
Download zip file
@endcomponent

This file will be deleted at {{ $deletionDatetime->format('Y-m-d H:i:s') }}

Kind regards,<br>
{{ config('app.name') }}
@endcomponent
