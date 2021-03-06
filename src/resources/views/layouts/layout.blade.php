<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ $title ?? env('APP_NAME') }}</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>

<body>

<main class="p-4">
    <div class="container">
        @yield('content')
    </div>
</main>

<script src="{{asset('js/app.js')}}" defer></script>

@yield('scripts')

</body>
</html>
