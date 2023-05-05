@extends('layouts.app')
@section('title', 'Company Profile')


@section('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('page-header', 'Company Profile')
@section('content')
    <div class="d-flex flex-column">
        <div class="container-fluid">
            <div class="row">

                <section>
                    <div class="">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        @livewire('admin.company-profile')
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="container-fluid">
                                    <div class="row justify-content-center">
                                        <div class="">
                                            <div class="card">
                                                <div class="card-header">{{ __('Company Logo') }}</div>
                                                <div class="card-body">
                                                    @livewire('admin.options.web-logo')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

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
                }).then((result) => {
                    if (event.detail.reload == true) {
                        location.reload();
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
