@extends('layouts.app')
@section('title', 'Web Navigations')

@section('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('page-header', 'Web Navigations')
@section('content')
    <div class="col-lg-9">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="card">
                    <div class="card-body">
                        @livewire('admin.menus.navigation-menus')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @livewireScripts
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        window.addEventListener('close-modal', event => {
            $(event.detail.modal_id).modal('hide');
        });

        window.addEventListener('swal-modal', event => {
            if (event.detail.title == "saved") {
                Swal.fire({
                    icon: 'success',
                    title: event.detail.message,
                    confirmButtonText: 'Ok',
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            } else if (event.detail.title == "error") {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to process request.',
                    text: 'Something went wrong, please try again.',
                    allowOutsideClick: false
                });
            }
        });
    </script>
@endsection
