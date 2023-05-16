@extends('layouts.app')
@section('title', 'Site Maintenance')

@section('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('page-header', 'Site Maintenance')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <section>
                <div class="">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="accordion" id="accordionDepartments">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingDepartments">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseDepartments"
                                                    aria-expanded="false" aria-controls="collapseDepartments">
                                                    Departments
                                                </button>
                                            </h2>
                                            <div id="collapseDepartments" class="accordion-collapse collapse"
                                                aria-labelledby="headingDepartments" data-bs-parent="#accordionDepartments">
                                                <div class="accordion-body">
                                                    @livewire('admin.options.departments-option')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="accordion" id="accordionUserTypes">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingUserTypes">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseUserTypes"
                                                    aria-expanded="false" aria-controls="collapseUserTypes">
                                                    User Types
                                                </button>
                                            </h2>
                                            <div id="collapseUserTypes" class="accordion-collapse collapse"
                                                aria-labelledby="headingUserTypes" data-bs-parent="#accordionUserTypes">
                                                <div class="accordion-body">
                                                    @livewire('admin.options.user-types-option')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="container">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="accordion" id="accordionSiteBanner">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingSiteBanner">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseSiteBanner"
                                                    aria-expanded="false" aria-controls="collapseSiteBanner">
                                                    Site Banners
                                                </button>
                                            </h2>
                                            <div id="collapseSiteBanner" class="accordion-collapse collapse"
                                                aria-labelledby="headingSiteBanner" data-bs-parent="#accordionSiteBanner">
                                                <div class="accordion-body">
                                                    @livewire('admin.options.site-banner')
                                                </div>
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

        window.addEventListener('delete-selected', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteSelectedBanner');
                }
            });
        });

        window.addEventListener('deleted-selected', event => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: 'Selected banner has been deleted.'
            });
        });
    </script>
@endsection
