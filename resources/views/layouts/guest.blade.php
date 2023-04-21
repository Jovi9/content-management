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
    <style>
        body {
            /* min-height: 75rem; */
            padding-top: 4.5rem;
        }
    </style>
    @yield('styles')
</head>

<body class="">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow fixed-top">
        <div class="container">
            <a href="{{ route('public-home') }}">
                <div class="navbar-brand">
                    <img src="{{ asset('storage/logo/sys_logo.png') }}" alt="LOGO" class=""
                        style="opacity: .8" width="50px">
                </div>
            </a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navMenus"
                aria-controls="navMenus" aria-expanded="false" aria-label="Toggle Navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenus">
                <ul class="navbar-nav gap-lg-2">
                    <li class="nav-item">
                        <a href="{{ route('public-home') }}" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('public-about') }}" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('public-contact') }}" class="nav-link">Contact Us</a>
                    </li>
                    @if ($mainMenus)
                        @foreach ($mainMenus as $mainMenu)
                            @if ($mainMenu['subMenu'] === 'none')
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page"
                                        href="{{ route('public-show', ['main' => $mainMenu['mainURI']]) }}">{{ $mainMenu['mainMenu'] }}</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ $mainMenu['mainMenu'] }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        @foreach ($mainMenu['subMenu'] as $subMenu)
                                            <li><a class="dropdown-item"
                                                    href="{{ route('public-show', ['main' => $mainMenu['mainURI'] . '/' . $subMenu->subURI]) }}">{{ $subMenu->subMenu }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="d-none d-lg-flex">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">DASHBOARD</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">LOGIN</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="">
        @yield('content')
    </main>





    {{-- jquery --}}
    <script src="{{ asset('assets/jquery/jquery-3.6.3.min.js') }}"></script>
    @yield('scripts')
</body>

</html>
