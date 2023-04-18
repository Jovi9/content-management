<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- fontawesome --}}
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-6-4-0/css/all.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.2.0-dist/css/bootstrap.min.css') }}">
    <script src="{{ asset('assets/bootstrap-5.2.0-dist/js/bootstrap.min.js') }}" defer></script> --}}

    @yield('styles')
</head>

<body class="">
    <main>
        @yield('content')
    </main>

    @yield('scripts')
</body>

</html>
