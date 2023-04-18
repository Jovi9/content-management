@extends('layouts.app')
@section('title', 'Profile')

@section('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('page-header', 'Profile')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <img src="{{ asset('storage/logo/user_logo.png') }}" alt="avatar"
                                        class="rounded-circle img-fluid" style="width: 150px;">
                                    <h4 class="my-3" id="username">{{ Auth::user()->firstName }}</h4>
                                    <div class="d-flex justify-content-center mt-3">
                                        <button type="button" class="btn btn-primary" id="btn_change_picture">Change
                                            Picture</button>
                                    </div>
                                    <div class="d-flex justify-content-center mb-2 mt-2">
                                        <!-- edit profile -->
                                        @livewire('user.update-profile')
                                        <a href="{{ route('user-activities') }}"><button type="button"
                                                class="btn btn-outline-primary ms-1">Activity Log</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">User Type</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">
                                                {{ ucwords(Auth::user()->getRoleNames()[0]) }}
                                            </p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Employee ID</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">
                                                {{ Auth::user()->employeeID }}
                                            </p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Full Name</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">
                                                {{ Auth::user()->firstName . ' ' . Auth::user()->middleInitial . ' ' . Auth::user()->lastName }}
                                            </p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Sex</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ Auth::user()->sex }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Date of Birth</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">
                                                {{ date('M-d-Y', strtotime(Auth::user()->dateOfBirth)) }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Age</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ Auth::user()->age . ' year/s old' }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Place of Birth</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ Auth::user()->placeOfBirth }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Civil Status</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ Auth::user()->civilStatus }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Department</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">
                                                {{ ucwords($department->departmentName) }}
                                            </p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Email</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Contact Number</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ Auth::user()->contactNo }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- change password --}}
                    @livewire('user.change-password')
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
                    location.reload();
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
