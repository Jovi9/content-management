<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    {{-- tailwind elements --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" /> --}}
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- <body class="font-sans text-gray-900 antialiased">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</body> --}}

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @if (isset($navigation))
            @include('layouts.guest_navigation')
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script> --}}
</body>

</html>
