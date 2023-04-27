@extends('layouts.guest')

@section('title', 'About')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
    <style>
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
@endsection

@section('content')
    <div class="bg-dark text-secondary px-4 py-5 text-center mb-5" id="banner"
        style="background-image: url({{ asset('storage/logo/home_banner.jpg') }})">
        <div class="py-5">
            <h1 class="display-5 fw-bold text-white">About College of Information and <br> Communications Technology</h1>
        </div>
    </div>

    @if ($contents)
        @foreach ($contents as $content)
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="bg-white">
                                <div class="container px-4 py-4">
                                    <h2 class="pb-2 border-bottom border-4">{{ $content->title }}</h2>
                                    <div class="row mt-4">
                                        {!! $content->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <section class="bg-white py-5" id="contact-us">
        <div class="container px-4 py-5 shadow">
            <h2 class="pb-2 border-bottom border-4">Contact Us</h2>
            <div class="row">
                <div class="col-md-5 order-md-1 mt-3">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3878.191652486972!2d124.2085573719072!3d13.585099950210193!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a016e5733747e7%3A0x686563c9d71ae37e!2sCict%20Building!5e0!3m2!1sen!2sph!4v1682554554130!5m2!1sen!2sph"
                        class="w-100" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="col-md-7 order-md-2 mt-5 mt-lg-3">
                    <form action="{{ route('public-contact-us') }}" method="post" class="fs-5" novalidate
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-sm-10">
                                <label for="txtName" class="form-label">Full Name *</label>
                                <input type="text" class="form-control fs-5 @error('fullname') is-invalid @enderror"
                                    id="txtName" required name="fullname">
                                @error('fullname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-10">
                                <label for="txtEmail" class="form-label">Email *</label>
                                <input type="email" class="form-control fs-5 @error('email') is-invalid @enderror"
                                    id="txtEmail" required name="email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-10">
                                <label for="txtSubject" class="form-label">Message Subject *</label>
                                <input type="text" class="form-control fs-5 @error('subject') is-invalid @enderror"
                                    id="txtSubject" required name="subject">
                                @error('subject')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-10">
                                <label for="txtMessage" class="form-label">Your Message *</label>
                                <textarea id="txtMessage" cols="30" rows="8" class="form-control fs-5 @error('message') is-invalid @enderror"
                                    name="message" required></textarea>
                                @error('message')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row container">
                            <button type="submit" class="btn btn-primary col-sm-6">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    @if ($errors->get('fullname') || $errors->get('email') || $errors->get('subject') || $errors->get('message'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Failed to send email.',
                text: 'Please make sure you have entered all the required details before submitting.',
                allowOutsideClick: false
            }).then((result) => {
                location.href = '#contact-us';
            });
        </script>
    @endif
    @if (Session::has('no-email'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Failed to send email.',
                text: 'Service is currently unavailable.',
                allowOutsideClick: false
            }).then((result) => {
                @php
                    Session::forget('no-email');
                @endphp
                location.reload();
            });
        </script>
    @endif
    @if (Session::has('mail-sent'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Message sent successfully.',
                confirmButtonText: 'Ok',
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            }).then((result) => {
                @php
                    Session::forget('mail-sent');
                @endphp
                location.reload();
            });
        </script>
    @endif
@endsection
