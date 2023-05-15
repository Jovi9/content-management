@extends('layouts.guest')

@section('title', $menuName)

@section('content')
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active carousel-item-page">
                <img src="{{ asset('storage/images/1.jpg') }}" class="d-block w-100 carousel-img" alt="Image">

                <div class="container">
                    <div class="carousel-caption text-start">
                        <h1>CoEd Spearheads BUROGKOS: a team building activity, enchances gender sensitive powerhouse
                        </h1>
                    </div>
                </div>
            </div>
            <div class="carousel-item carousel-item-page">
                <img src="{{ asset('storage/images/2.jpg') }}" class="d-block w-100 carousel-img" alt="Image">

                <div class="container">
                    <div class="carousel-caption text-start">
                        <h1>CoEd Spearheads BUROGKOS: a team building activity, enchances gender sensitive powerhouse
                        </h1>
                    </div>
                </div>
            </div>
            <div class="carousel-item carousel-item-page">
                <img src="{{ asset('storage/images/3.jpg') }}" class="d-block w-100 carousel-img" alt="Image">

                <div class="container">
                    <div class="carousel-caption text-start">
                        <h1>CoEd Spearheads BUROGKOS: a team building activity, enchances gender sensitive powerhouse
                        </h1>
                    </div>
                </div>
            </div>
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
