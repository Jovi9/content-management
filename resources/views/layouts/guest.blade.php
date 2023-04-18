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

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/adminlte/admin/css/adminlte.min.css') }}">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @yield('styles')
</head>

<body class="hold-transition layout-top-nav">

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="{{ route('public-home') }}" class="navbar-brand">
                    <img src="{{ asset('storage/logo/sys_logo.png') }}" alt="LOGO"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">CMS</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
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
                                @if ($mainMenu['subMenu'] == 'none')
                                    <li class="nav-item">
                                        <a href="{{ route('public-show', ['main' => $mainMenu['mainURI']]) }}"
                                            class="nav-link">{{ $mainMenu['mainMenu'] }}</a>
                                    </li>
                                @else
                                    <li class="nav-item dropdown">
                                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"
                                            class="nav-link dropdown-toggle">{{ $mainMenu['mainMenu'] }}</a>
                                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                            @foreach ($mainMenu['subMenu'] as $subMenu)
                                                <li><a href="{{ route('public-show', ['main' => $mainMenu['mainURI'] . '/' . $subMenu->subURI]) }}"
                                                        class="dropdown-item">{{ $subMenu->subMenu }}</a></li>
                                            @endforeach
                                            {{-- <li class="dropdown-divider"></li> --}}

                                            <!-- Level two dropdown-->
                                            {{-- <li class="dropdown-submenu dropdown-hover">
                                                <a id="dropdownSubMenu2" href="#" role="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    class="dropdown-item dropdown-toggle">Hover for action</a>
                                                <ul aria-labelledby="dropdownSubMenu2"
                                                    class="dropdown-menu border-0 shadow">
                                                    <li>
                                                        <a tabindex="-1" href="#" class="dropdown-item">level
                                                            2</a>
                                                    </li>

                                                    <!-- Level three dropdown-->
                                                    <li class="dropdown-submenu">
                                                        <a id="dropdownSubMenu3" href="#" role="button"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false"
                                                            class="dropdown-item dropdown-toggle">level 2</a>
                                                        <ul aria-labelledby="dropdownSubMenu3"
                                                            class="dropdown-menu border-0 shadow">
                                                            <li><a href="#" class="dropdown-item">3rd level</a>
                                                            </li>
                                                            <li><a href="#" class="dropdown-item">3rd level</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <!-- End Level three -->

                                                    <li><a href="#" class="dropdown-item">level 2</a></li>
                                                    <li><a href="#" class="dropdown-item">level 2</a></li>
                                                </ul>
                                            </li> --}}
                                            <!-- End Level two -->
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>

                <!-- Right navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item">
                        @auth
                            <a href="{{ route('dashboard') }}" class="nav-link">DASHBOARD</a>
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="nav-link">LOGIN</a>
                            @endif
                        @endauth
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-header')</h1>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <main class="content">
                @yield('content')
            </main>
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->


    {{-- jquery --}}
    <script src="{{ asset('assets/jquery/jquery-3.6.3.min.js') }}"></script>
    {{-- bootstrap 4 --}}
    <script src="{{ asset('assets/adminlte/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/adminlte/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/adminlte/admin/js/adminlte.min.js') }}"></script>
    @yield('scripts')
</body>

</html>
