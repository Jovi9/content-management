@extends('layouts.guest')

@section('title', 'Home')

@section('styles')
    <style>
        .img {
            float: left;
            width: 100%;
            height: 10rem;
            background-size: cover;
        }
    </style>
@endsection

@section('content')
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @if (empty($banners))
                <div class="carousel-item active">
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
                    <div class="carousel-item @if ($key === 0) active @endif">
                        <img src="{{ Storage::url($banner['image']) }}" class="d-block w-100 carousel-img" alt="Image">

                        <div class="container">
                            <div class="carousel-caption">
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

    <div class="b-gray-divider"></div>

    <section class="py-5 bg-white">
        <div class="container mb-5 mt-5">
            <h2 class="pb-2 border-bottom border-4 mb-5 mt-5 container"><strong>News and Updates</strong></h2>
            @if (!$newsUpdates->isEmpty())
                <div class="slide-container p-4 swiper">
                    <div class="slide-content px-3 overflow-hidden">
                        <div class="slide-card-contents swiper-wrapper">
                            @foreach ($newsUpdates as $news)
                                <div class="slide-card swiper-slide">
                                    <div class="card mb-5" style="width: 18rem;">
                                        <div class="img" style="background-image: url({{ Storage::url($news->image) }})">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title"><strong>{{ $news->title }}</strong></h5>
                                            <p class="card-text cut-text">
                                                {{ substr(strip_tags($news->content), 0, 200) }}
                                            </p>
                                            <a href="#" class="btn btn-primary">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            @else
                <div class="d-flex align-items-center justify-content-center p-5" style="height:50vh;">
                    <div class="text-center">
                        {{-- <h1 class="display-1 fw-bold">404</h1> --}}
                        <p class="fs-3"> <span class="text-danger">Opps!</span> No News Found.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div class="b-gray-divider"></div>

    <section class="bg-white">
        <div class="container py-5">
            <div class="container mt-5 mb-5">
                <h2 class="pb-2 border-bottom border-4 mt-5 mb-5"><strong>Featured</strong></h2>
            </div>
            @if (!empty($featureds))
                <div class="row justify-content-center mb-5">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 mb-5">
                        @foreach ($featureds as $featured)
                            <div class="col d-flex align-items-start">
                                <div
                                    class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                                    <i class="fas fa-microchip p-3"></i>
                                </div>
                                <div>
                                    <h3 class="fs-2">{{ $featured['title'] }}</h3>
                                    <p class="cut-text">
                                        {{ substr(strip_tags($featured['content']), 0, 200) }}
                                    </p>
                                    @if ($featured['subURI'] === 'none')
                                        <a href="{{ $featured['mainURI'] }}/#{{ strtolower(str_replace(' ', '-', $featured['title'])) }}"
                                            class="btn btn-primary">
                                            Read More
                                        </a>
                                    @else
                                        <a href="{{ $featured['mainURI'] }}/{{ $featured['subURI'] }}/#{{ strtolower(str_replace(' ', '-', $featured['title'])) }}"
                                            class="btn btn-primary">
                                            Read More
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="d-flex align-items-center justify-content-center p-5" style="height:50vh;">
                    <div class="text-center">
                        {{-- <h1 class="display-1 fw-bold">404</h1> --}}
                        <p class="fs-3"> <span class="text-danger">Opps!</span> No Featured Found.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div class="b-gray-divider"></div>

    <section class="py-5 bg-white">
        <div class="container mt-5 mb-5">
            <h2 class="pb-2 border-bottom border-4 mt-5 mb-5"><strong>Gallery</strong></h2>
        </div>
        <div class="container">
            @if (!empty($images))
                <div class="row justify-content-center mb-5">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 mb-5">
                        @foreach ($images as $key => $imagee)
                            <div class="col">
                                <div class="card">
                                    <img src="{{ Storage::url($imagee) }}" class="" alt="Image">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="d-flex align-items-center justify-content-center p-5" style="height:50vh;">
                    <div class="text-center">
                        {{-- <h1 class="display-1 fw-bold">404</h1> --}}
                        <p class="fs-3"> <span class="text-danger">Opps!</span> No Gallery Images Found.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div class="b-gray-divider"></div>

    <section class="bg-white">
        <div class="container py-5">
            <div class="container mt-5 mb-5">
                <h2 class="pb-2 border-bottom border-4 mt-5 mb-5"><strong>Our Partners</strong></h2>
            </div>
            @if (!$partners->isEmpty())
                <div class="row justify-content-md-center mb-5">
                    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4 mb-5">
                        @foreach ($partners as $partner)
                            <div class="col">
                                <a href="{{ $partner->URL }}">
                                    <img src="{{ Storage::url($partner->image) }}" width="150px" alt="Image">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="d-flex align-items-center justify-content-center p-5" style="height:50vh;">
                    <div class="text-center">
                        {{-- <h1 class="display-1 fw-bold">404</h1> --}}
                        <p class="fs-3"> <span class="text-danger">Opps!</span> No Partners Found.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div class="b-gray-divider"></div>

@endsection

@section('scripts')
    <script>
        var swiper = new Swiper(".slide-content", {
            slidesPerView: 5,
            spaceBetween: 30,
            loop: false,
            centerSlide: true,
            fade: true,
            grabCursor: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 40,
                },
                650: {
                    slidesPerView: 2,
                },
                1000: {
                    slidesPerView: 3,
                },
                1230: {
                    slidesPerView: 4,
                },
            }
        });
    </script>
@endsection
