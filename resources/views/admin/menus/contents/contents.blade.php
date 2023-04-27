@extends('layouts.app')
@section('title', 'Contents')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('page-header', 'Add Contents')
@section('content')
    <div class="col-lg-9">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-responsive-sm" id="">
                            <thead>
                                <tr>
                                    <th scope="col">Main Menu</th>
                                    <th scope="col">Sub Menu</th>
                                    <th scope="col">URI</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ __('Home') }}</td>
                                    <td>{{ __('None') }}</td>
                                    <td><a href="{{ route('public-home') }}" target="_blank">
                                            <div>
                                                {{ __('/') }}
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="" checked disabled>
                                            <label class="form-check-label" for="}">
                                                {{ __('Enabled') }}
                                            </label>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                @if ($menus)
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td>{{ ucwords($menu['mainMenu']) }}</td>
                                            @if ($menu['subMenu'] == 'none')
                                                <td>{{ __('None') }}</td>
                                            @else
                                                <td>{{ ucwords($menu['subMenu']) }}</td>
                                            @endif
                                            <td>
                                                @if ($menu['subMenu'] == 'none')
                                                    <a href="{{ route('public-show', ['main' => $menu['mainURI']]) }}"
                                                        target="_blank">
                                                        <div>
                                                            {{ '/' . $menu['mainURI'] }}
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="{{ route('public-show', ['main' => $menu['mainURI'] . '/' . $menu['subURI']]) }}"
                                                        target="_blank">
                                                        <div>
                                                            {{ '/' . $menu['mainURI'] . '/' . $menu['subURI'] }}
                                                        </div>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($menu['subMenu'] == 'none')
                                                    <a href="{{ route('admin.contents-create', ['main' => $menu['mainURI']]) }}"
                                                        class="btn btn-primary"><i class="fa fa-plus"></i> Add Content</a>
                                                @else
                                                    <a href="{{ route('admin.contents-create', ['main' => $menu['mainURI'] . '/' . $menu['subURI']]) }}"
                                                        class="btn btn-primary"><i class="fa fa-plus"></i> Add Content</a>
                                                @endif
                                                @if ($menu['subMenu'] == 'none')
                                                    <a href="{{ route('admin.contents-show', ['main' => $menu['mainURI']]) }}"
                                                        class="btn btn-primary"><i class="fa fa-eye"></i> View Contents</a>
                                                @else
                                                    <a href="{{ route('admin.contents-show', ['main' => $menu['mainURI'] . '/' . $menu['subURI']]) }}"
                                                        class="btn btn-primary"><i class="fa fa-eye"></i> View Contents</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    @if (Session::has('saved'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'New Content Saved Successfully.',
                confirmButtonText: 'Ok',
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>
    @endif
@endsection
