<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <title>Shortener</title>
    <style>
        /*html, body {*/
        /*    margin: 0;*/
        /*    padding: 0;*/
        /*    width: 100%;*/
        /*    background-color: #d1d1d1*/
        /*}*/
        /*#mute {*/
        /*    position: absolute;*/
        /*}*/
        /*#mute.on {*/
        /*    opacity: 0.7;*/
        /*    z-index: 1000;*/
        /*    background: white;*/
        /*    height: 100%;*/
        /*    width: 100%;*/
        /*}*/
    </style>
</head>
<body>

{{--<div id="mute"></div>--}}
<div id="app"></div>
<!-- Scripts -->
{{--<script src="{{ asset('js/app.js') }}" defer></script>--}}
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
