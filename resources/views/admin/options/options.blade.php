@extends('layouts.app')
@section('title', 'Options')

@section('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('page-header', 'Options')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="departments-tab" data-bs-toggle="tab"
                                    data-bs-target="#departments" type="button" role="tab" aria-controls="departments"
                                    aria-selected="true">Departments</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="userTypes-tab" data-bs-toggle="tab" data-bs-target="#userTypes"
                                    type="button" role="tab" aria-controls="userTypes" aria-selected="false">User
                                    Types</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="tabOptions">
                            <div class="tab-pane fade show active" id="departments" role="tabpanel"
                                aria-labelledby="departments-tab">
                                <div class="col-lg-6 p-3">
                                    @livewire('admin.options.departments-option')
                                </div>
                            </div>
                            <div class="tab-pane fade" id="userTypes" role="tabpanel" aria-labelledby="userTypes-tab">
                                <div class="col-lg-6 p-3">
                                    @livewire('admin.options.user-types-option')
                                </div>
                            </div>
                        </div>
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
