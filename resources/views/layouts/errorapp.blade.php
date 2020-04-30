<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DomeinDNS') }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    @include('layouts.partials.favicon')
</head>
<body class="bg-gradient-domeindns-light">

<div class="container">

    <div class="row justify-content-center">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body py-4">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>

    </div>

</div>

<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
