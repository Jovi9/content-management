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
    <link rel="stylesheet" href="{{ asset('assets/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/guest/guest.css') }}">
    @yield('styles')
</head>

<body class="">
    <div class="sticky-top">
        <div class="border-bottom d-none d-md-flex darkblue">
            <div class="container d-flex flex-wrap">
                <ul class="nav me-auto ms-5">
                    <li class="nav-item">
                        @if (!empty($companyProfile))
                            <a href="@if ($companyProfile->mainURI === '') javascript:void(0) @else {{ $companyProfile->mainURI }} @endif"
                                class="nav-link text-white px-2 active" aria-current="page">
                                @if ($companyProfile->companyName === '')
                                    {{ __('Web Builder') }}
                                @else
                                    {{ $companyProfile->companyName }}
                                @endif
                            </a>
                        @else
                            <a href="javascript:void(0)" class="nav-link text-white px-2 active" aria-current="page">
                                {{ __('Web Builder') }}
                            </a>
                        @endif
                    </li>
                </ul>
                <ul class="nav me-5">
                    @auth
                        <li class="nav-item"><a href="{{ route('dashboard') }}"
                                class="nav-link link-dark px-2"><u>DASHBOARD</u></a>
                        </li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}"
                                class="nav-link link-dark px-2"><u>LOGIN</u></a>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>

        <div class="border-bottom d-flex d-md-none darkblue">
            <div class="container d-flex flex-wrap">
                <ul class="nav me-auto">
                    <li class="nav-item">
                        @if (!empty($companyProfile))
                            <a href="@if ($companyProfile->mainURI === '') javascript:void(0) @else {{ $companyProfile->mainURI }} @endif"
                                class="nav-link text-white px-2 active" aria-current="page">
                                @if ($companyProfile->companySub === '')
                                    {{ $companyProfile->companyName }}
                                @else
                                    {{ $companyProfile->companySub }}
                                @endif
                            </a>
                        @else
                            <a href="javascript:void(0)" class="nav-link text-white px-2 active" aria-current="page">
                                {{ __('Web Builder') }}
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        <header class="py-4 bg-white border-bottom">
            <div class="container d-flex flex-wrap justify-content-center">
                <a href="{{ route('public-home') }}"
                    class="d-flex align-items-center me-lg-auto ms-lg-5 text-dark text-decoration-none">
                    <img src="{{ asset('storage/logo/sys_logo.png') }}" alt="LOGO" class="d-none d-md-flex"
                        style="opacity: .8" width="50px">
                    <span class="fs-5 mx-4 d-none d-lg-flex">
                        @if (!empty($companyProfile))
                            @if ($companyProfile->companySub === '')
                                {{ $companyProfile->companyName }}
                            @else
                                {{ $companyProfile->companySub }}
                            @endif
                        @else
                            {{ __('Web Builder') }}
                        @endif
                    </span>

                    <img src="{{ asset('storage/logo/sys_logo.png') }}" alt="LOGO" class="d-flex d-md-none"
                        style="opacity: .8" width="50px">
                </a>
                <a href="#" class="fs-5 mx-4 d-flex ms-auto d-lg-none">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenus"
                        aria-controls="navMenus" aria-expanded="false" aria-label="Toggle Navigation">
                        <i class="fas fa-bars fs-1"></i>
                    </button>
                </a>
            </div>
        </header>
        <div class="b-divider" style="height:0.1rem;"></div>

        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow">
            <div class="container">
                <div class="collapse navbar-collapse" id="navMenus">
                    <ul class="navbar-nav gap-lg-4 mx-lg-5">
                        <li class="nav-item item-link">
                            <a href="{{ route('public-home') }}" class="nav-link blue-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('public-about') }}" class="nav-link blue-link">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('public-news') }}" class="nav-link blue-link">News</a>
                        </li>
                        @if ($mainMenus)
                            @foreach ($mainMenus as $mainMenu)
                                @if ($mainMenu['subMenu'] === 'none')
                                    <li class="nav-item">
                                        <a class="nav-link blue-link" aria-current="page"
                                            href="{{ route('public-show', ['main' => $mainMenu['mainURI']]) }}">{{ $mainMenu['mainMenu'] }}</a>
                                    </li>
                                @else
                                    <li class="nav-item dropdown">
                                        <a class="nav-link  blue-link dropdown-toggle" href="#"
                                            id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            {{ $mainMenu['mainMenu'] }}
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            @foreach ($mainMenu['subMenu'] as $subMenu)
                                                <li><a class="dropdown-item blue-link"
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

    <div class="b-divider" style="height:0.2rem;"></div>

    <footer class="">
        <div class="lightblue text-white p-4">
            <div class="container">
                <div class="row py-5 my-5 mx-lg-5">
                    <div class="row">
                        <div class="col-md-3">
                            @if (!empty($companyProfile))
                                @if ($companyProfile->companyName === '')
                                    <h5 class="border-bottom border-2 footer-link-head">
                                        <strong>{{ __('Web Builder') }}</strong>
                                    </h5>
                                @else
                                    <h5 class="border-bottom border-2 footer-link-head">
                                        <strong>{{ $companyProfile->companyName }}</strong>
                                    </h5>
                                @endif
                                <ul class="nav flex-column">
                                    @if (!($companyProfile->companySub === ''))
                                        <li class="nav-item mb-2 footer-link"><b>{{ $companyProfile->companySub }}</b>
                                        </li>
                                    @endif
                                    <li class="nav-item mb-2 footer-link">{{ $companyProfile->companyAddress }}</li>
                                    <li class="nav-item mb-2 footer-link">{{ $companyProfile->email }}</li>
                                </ul>
                            @else
                                <h5 class="border-bottom border-2 footer-link-head">
                                    <strong>{{ __('Web Builder') }}</strong>
                                </h5>
                                <ul class="nav flex-column">
                                    <li class="nav-item mb-2 footer-link"><b></b>
                                    </li>
                                    <li class="nav-item mb-2 footer-link">{{ __('Philippines') }}</li>
                                    <li class="nav-item mb-2 footer-link">{{ __('contact-us@web-bbuilder.com') }}</li>
                                </ul>
                            @endif
                        </div>

                        <div class="col-md-1"></div>

                        <div class="col-md-8 mt-5 mt-md-0">
                            <div class="row">
                                <div class="col-md-3">
                                    <ul class="nav flex-column">
                                        <li class="nav-item mb-2"><a href="{{ route('public-home') }}"
                                                class="nav-link p-0 text-white footer-link-head "><u>Home</u></a>
                                        </li>
                                        <li class="nav-item mb-2"><a href="{{ route('public-about') }}"
                                                class="nav-link p-0 text-white  footer-link-head "><u>About</u></a>
                                        </li>
                                        <li class="nav-item mb-2"><a href="{{ route('public-news') }}"
                                                class="nav-link p-0 text-white  footer-link-head "><u>News</u></a></li>
                                        @if ($mainMenus)
                                            @foreach ($mainMenus as $mainMenu)
                                                @if ($mainMenu['subMenu'] === 'none')
                                                    <li class="nav-item mb-2"><a
                                                            href="{{ route('public-show', ['main' => $mainMenu['mainURI']]) }}"
                                                            class="nav-link p-0 text-white footer-link-head"><u>{{ $mainMenu['mainMenu'] }}</u></a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                @if ($mainMenus)
                                    @foreach ($mainMenus as $mainMenu)
                                        @if (!($mainMenu['subMenu'] === 'none'))
                                            <div class="col-md-3 mt-4 mt-md-0">
                                                <h5 class="border-bottom border-2  footer-link-head">
                                                    {{ $mainMenu['mainMenu'] }}</h5>
                                                <ul class="nav flex-column">
                                                    @foreach ($mainMenu['subMenu'] as $subMenu)
                                                        <li class="nav-item mb-2"><a
                                                                href="{{ route('public-show', ['main' => $mainMenu['mainURI'] . '/' . $subMenu->subURI]) }}"
                                                                class="nav-link p-0 text-white  footer-link">{{ $subMenu->subMenu }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="b-divider" style="height:0.1rem;"></div>

        <div class="darkblue">
            <div class="container d-flex flex-wrap">
                <ul class="nav me-auto mx-lg-5">
                    @if (!empty($companyProfile))
                        <li class="nav-item"><a href="{{ $companyProfile->mainURI }}" target="_blank"
                                class="nav-link text-white px-2 active footer-link" aria-current="page">
                                &copy; 2023
                                <u>
                                    @if ($companyProfile->companyName === '')
                                        {{ __('Web Builder') }}
                                    @else
                                        {{ $companyProfile->companyName }}
                                    @endif
                                </u>
                                @if (!($companyProfile->companySub === ''))
                                    {{ __(' - ') . $companyProfile->companySub }}
                                @endif
                                All Rights Reserved. {{ $companyProfile->companyAddress }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item"><a href="javascript:void(0)"
                                class="nav-link text-white px-2 active footer-link" aria-current="page">
                                &copy; 2023 <u>Web Builder</u>
                                All Rights Reserved. Philippines.
                            </a></li>
                    @endif
                </ul>
            </div>
        </div>
    </footer>

    {{-- jquery --}}
    <script src="{{ asset('assets/jquery/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/guest/guest.js') }}"></script>
    @yield('scripts')
</body>

</html>
