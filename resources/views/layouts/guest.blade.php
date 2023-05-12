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

        }

        #banner {
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            position: relative;
            z-index: 2;
        }

        #banner::after {
            content: "";
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgba(21, 20, 51, 0.8);
            z-index: -1;
        }
    </style>
    @yield('styles')
</head>

<body class="">
    <div class=" bg-light border-bottom d-none d-md-flex">
        <div class="container d-flex flex-wrap">
            <ul class="nav me-auto">
                <li class="nav-item"><a href="https://catsu.edu.ph/" target="_blank"
                        class="nav-link link-dark px-2 active" aria-current="page">Catanduanes State University
                        Calatagan, Virac, Catanduanes</a></li>
            </ul>
            <ul class="nav">
                @auth
                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link link-dark px-2"><u>DASHBOARD</u></a>
                    </li>
                @else
                    <li class="nav-item"><a href="{{ route('login') }}" class="nav-link link-dark px-2"><u>LOGIN</u></a></li>
                @endauth

            </ul>
        </div>
    </div>
    <div class="sticky-top">
        <header class="py-4 bg-white border-bottom">
            <div class="container d-flex flex-wrap justify-content-center">
                <a href="/" class="d-flex align-items-center me-lg-auto text-dark text-decoration-none">
                    <img src="{{ asset('storage/logo/sys_logo.png') }}" alt="LOGO" class=""
                        style="opacity: .8" width="50px">
                    <span class="fs-5 mx-4 d-none d-md-flex">College of Information and Communications Technology</span>
                </a>
                <a href="#" class="fs-5 mx-4 d-flex ms-auto d-md-none">
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenus"
                    aria-controls="navMenus" aria-expanded="false" aria-label="Toggle Navigation">
                    <i class="fas fa-bars fs-1"></i>
                </button>
                </a>
            </div>
        </header>

        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
            <div class="container">
                {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenus"
                    aria-controls="navMenus" aria-expanded="false" aria-label="Toggle Navigation">
                    <i class="fas fa-bars"></i>
                </button> --}}
                <div class="collapse navbar-collapse" id="navMenus">
                    <ul class="navbar-nav gap-lg-4 ">
                        <li class="nav-item">
                            <a href="{{ route('public-home') }}" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('public-about') }}" class="nav-link">About</a>
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
            </div>
        </nav>
    </div>

    <main class="">
        @yield('content')
    </main>

    <div class="bg-secondary text-white p-4 mt-5">
        <div class="container">
            <footer class="py-5">
                <div class="row">
                    <div class="col-6 col-md-2 mb-3">
                        <h5 class=" text-white">Pages</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="{{ route('public-home') }}"
                                    class="nav-link p-0 text-white ">Home</a>
                            </li>
                            <li class="nav-item mb-2"><a href="{{ route('public-about') }}"
                                    class="nav-link p-0 text-white ">About</a></li>
                            @if ($mainMenus)
                                @foreach ($mainMenus as $mainMenu)
                                    @if ($mainMenu['subMenu'] === 'none')
                                        <li class="nav-item mb-2"><a
                                                href="{{ route('public-show', ['main' => $mainMenu['mainURI']]) }}"
                                                class="nav-link p-0 text-white ">{{ $mainMenu['mainMenu'] }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    {{-- @if ($mainMenus)
                        <div class="col-6 col-md-2 mb-3">
                            <h5 class=" text-white">Pages</h5>
                            <ul class="nav flex-column">
                                @foreach ($mainMenus as $mainMenu)
                                    @if ($mainMenu['subMenu'] === 'none')
                                        <li class="nav-item mb-2"><a
                                                href="{{ route('public-show', ['main' => $mainMenu['mainURI']]) }}"
                                                class="nav-link p-0 text-white ">{{ $mainMenu['mainMenu'] }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    @if ($mainMenus)
                        @foreach ($mainMenus as $mainMenu)
                            @if (!($mainMenu['subMenu'] === 'none'))
                                <div class="col-6 col-md-2 mb-3">
                                    <h5 class=" text-white">{{ $mainMenu['mainMenu'] }}</h5>
                                    <ul class="nav flex-column">
                                        @foreach ($mainMenu['subMenu'] as $subMenu)
                                            <li class="nav-item mb-2"><a
                                                    href="{{ route('public-show', ['main' => $mainMenu['mainURI'] . '/' . $subMenu->subURI]) }}"
                                                    class="nav-link p-0 text-white ">{{ $subMenu->subMenu }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    @endif

                    {{-- <div class="col-md-5 offset-md-1 mb-3">
                        <form>
                            <h5 class=" text-white">Subscribe to our newsletter</h5>
                            <p>Monthly digest of what's new and exciting from us.</p>
                            <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                                <label for="newsletter1" class="visually-hidden">Email address</label>
                                <input id="newsletter1" type="text" class="form-control"
                                    placeholder="Email address">
                                <button class="btn btn-primary" type="button">Subscribe</button>
                            </div>
                        </form>
                    </div> --}}
                </div>

                <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top ">
                    <p>&copy; 2023 Catanduanes State University - College of Information and Communications Technology.
                        All Rights Reserved. <br>
                        Calatagan Virac, Catanduanes</p>
                    {{-- <ul class="list-unstyled d-flex">
                        <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24"
                                    height="24">
                                    <use xlink:href="#twitter" />
                                </svg></a></li>
                        <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24"
                                    height="24">
                                    <use xlink:href="#instagram" />
                                </svg></a></li>
                        <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24"
                                    height="24">
                                    <use xlink:href="#facebook" />
                                </svg></a></li>
                    </ul> --}}
                </div>
            </footer>
        </div>
    </div>

    {{-- jquery --}}
    <script src="{{ asset('assets/jquery/jquery-3.6.3.min.js') }}"></script>
    @yield('scripts')
</body>

</html>
