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
    {{-- <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.2.0-dist/css/bootstrap.min.css') }}">
    <script src="{{ asset('assets/bootstrap-5.2.0-dist/js/bootstrap.min.js') }}" defer></script> --}}
    @yield('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('dashboard') }}" class="nav-link">CONTENT MANAGEMENT</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                {{-- user drop --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fas fa-user"></i>
                        @if (Auth::user())
                            {{ Auth::user()->firstName }}
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                        @role('administrator')
                            <a href="{{ route('admin.options-index') }}" class="dropdown-item">
                                <i class="fas fa-gears mr-2"></i> Site Maintenance
                            </a>
                            <div class="dropdown-divider"></div>
                        @endrole
                        <a href="{{ route('user-profile') }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> My Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('user-activities') }}" class="dropdown-item">
                            <i class="fas fa-clock-rotate-left mr-2"></i> Activity Log
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="fas fa-right-from-bracket mr-2"></i> Logout
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link text-center">
                {{-- <img src="{{ url('storage/logo/sys_logo.png') }}" alt="LOGO" class="brand-image img-circle elevation-3"
                    style="opacity: .8"> --}}
                <img src="{{ asset('storage/logo/sys_logo.png') }}" alt="LOGO" class="img-fluid" width="25%">
                {{-- <span class="brand-text font-weight-light">Content Management System</span> --}}
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link @if (Route::is('dashboard')) active @endif">
                                <i class="nav-icon fas fa-gauge-high"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        @role('administrator')
                            <li class="nav-item">
                                <a href="{{ route('admin.users-index') }}"
                                    class="nav-link @if (Route::is('admin.users-index')) active @endif">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Users
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.company-profile-index') }}"
                                    class="nav-link @if (Route::is('admin.company-profile-index')) active @endif">
                                    <i class="nav-icon fas fa-building"></i>
                                    <p>
                                        Company Profile
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.navigations-index') }}"
                                    class="nav-link @if (Route::is('admin.navigations-index')) active @endif">
                                    <i class="nav-icon fas fa-bars"></i>
                                    <p>
                                        Web Navigations
                                    </p>
                                </a>
                            </li>
                        @endrole
                        <li
                            class="nav-item
                        @if (Route::is('admin.contents-index') ||
                                Route::is('admin.contents-manage') ||
                                Route::is('admin.news-page') ||
                                Route::is('admin.featured-page')) menu-open @endif"">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Manage Contents
                                    <i class="right fas fa-angle-left"></i>
                                    {{-- <span class="badge badge-info right">6</span> --}}
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.contents-index') }}"
                                        class="nav-link @if (Route::is('admin.contents-index')) active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Page Contents</p>
                                    </a>
                                </li>
                                @role('administrator')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.contents-manage') }}"
                                            class="nav-link @if (Route::is('admin.contents-manage')) active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Manage Contents
                                            </p>
                                        </a>
                                    </li>
                                @endrole
                                <li class="nav-item">
                                    <a href="{{ route('admin.news-page') }}"
                                        class="nav-link @if (Route::is('admin.news-page')) active @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>News</p>
                                    </a>
                                </li>
                                @role('administrator')
                                    <li class="nav-item">
                                        <a href="{{ route('admin.featured-page') }}"
                                            class="nav-link @if (Route::is('admin.featured-page')) active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Featured
                                            </p>
                                        </a>
                                    </li>
                                @endrole
                            </ul>
                        </li>
                        @role('administrator')
                            <li class="nav-item">
                                <a href="{{ route('admin.trash-page') }}"
                                    class="nav-link @if (Route::is('admin.trash-page')) active @endif">
                                    <i class="nav-icon fas fa-trash"></i>
                                    <p>
                                        Trash
                                    </p>
                                </a>
                            </li>
                        @endrole
                        <li class="nav-item">
                            <a href="{{ route('public-home') }}" class="nav-link">
                                <i class="nav-icon far fa-eye"></i>
                                <p>
                                    Guest View
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-header">PAGE CONTENTS</li> --}}
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('page-header')</h1>
                        </div>
                        @yield('page-header-right')
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <main class="content">
                @yield('content')
            </main>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                Calatagan, Virac, Catanduanes
            </div>
            <strong>
                Copyright &copy; 2023 Catanduanes State University - College of Information and Communications
                Technology</strong>
            All rights reserved.
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
