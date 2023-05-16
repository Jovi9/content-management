@extends('layouts.guest')

@section('title', $menuName)

@section('content')
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @if (empty($banners))
                <div class="carousel-item carousel-item-page active">
                    <img src="{{ asset('storage/logo/site_banner.jpg') }}" class="d-block w-100 carousel-img" alt="Image">
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1></h1>
                            <p></p>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($banners as $key => $banner)
                    <div class="carousel-item carousel-item-page @if ($key === 0) active @endif">
                        <img src="{{ Storage::url($banner['image']) }}" class="d-block w-100 carousel-img" alt="Image">

                        <div class="container">
                            <div class="carousel-caption text-start">
                                <h1>{{ $banner['title'] }}</h1>
                                <p>{{ $banner['shortDesc'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="b-divider"></div>
    <section class="py-5"></section>

    @if (!$contents->isEmpty())
        @if ($contents)
            @foreach ($contents as $content)
                <div class="container py-3" id="{{ strtolower(str_replace(' ', '-', $content->title)) }}">
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
    @else
        <div class="d-flex align-items-center justify-content-center p-5" style="height:50vh;">
            <div class="text-center">
                {{-- <h1 class="display-1 fw-bold">404</h1> --}}
                <p class="fs-3"> <span class="text-danger">Opps!</span> Empty Page.</p>
                <p class="lead">
                    The page you’re looking for currently have no content.
                </p>
                <a href="{{ route('public-home') }}" class="btn btn-primary">Go Home</a>
            </div>
        </div>
    @endif

    <section class="py-5"></section>
@endsection

@section('scripts')
    <script>
        $('img').addClass('img-fluid');
    </script>
@endsection
