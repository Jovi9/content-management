@extends('layouts.guest')

@section('title', 'Home')

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

    <div class="b-gray-divider"></div>

    <section class="py-5 bg-white">
        <div class="container mb-5 mt-5">
            <h2 class="pb-2 border-bottom border-4 mb-5 mt-5 container"><strong>News and Updates</strong></h2>
            <div class="slide-container p-4 swiper">
                <div class="slide-content px-3 overflow-hidden">
                    <div class="slide-card-contents swiper-wrapper">
                        <div class="slide-card swiper-slide">
                            <div class="card mb-5" style="width: 18rem;">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Research Activities</strong></h5>
                                    <p class="card-text cut-text">Some quick example text to build on the card title and
                                        make up the
                                        bulk
                                        of the card's content. Some quick example text to build on the card title and make
                                        up the
                                        bulk
                                        of the card's content.</p>
                                    <a href="#" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="slide-card swiper-slide h-100">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Card title</strong></h5>
                                    <p class="card-text cut-text">Words in the woods are found anywhere in the world. Words
                                        in the woods are found around the world.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="slide-card swiper-slide h-100">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Card title</strong></h5>
                                    <p class="card-text cut-text">Words in the woods are found anywhere in the world. Words
                                        in the woods are found around the world.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="slide-card swiper-slide h-100">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Card title</strong></h5>
                                    <p class="card-text cut-text">Words in the woods are found anywhere in the world. Words
                                        in the woods are found around the world.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="slide-card swiper-slide h-100">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Card title</strong></h5>
                                    <p class="card-text cut-text">Words in the woods are found anywhere in the world. Words
                                        in the woods are found around the world.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="slide-card swiper-slide h-100">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Card title</strong></h5>
                                    <p class="card-text cut-text">Words in the woods are found anywhere in the world. Words
                                        in the woods are found around the world.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="slide-card swiper-slide h-100">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Card title</strong></h5>
                                    <p class="card-text cut-text">Words in the woods are found anywhere in the world. Words
                                        in the woods are found around the world.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="slide-card swiper-slide h-100">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Card title</strong></h5>
                                    <p class="card-text cut-text">Words in the woods are found anywhere in the world. Words
                                        in the woods are found around the world.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="slide-card swiper-slide h-100">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Card title</strong></h5>
                                    <p class="card-text cut-text">Words in the woods are found anywhere in the world. Words
                                        in the woods are found around the world.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="slide-card swiper-slide h-100">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Card title</strong></h5>
                                    <p class="card-text cut-text">Words in the woods are found anywhere in the world. Words
                                        in the woods are found around the world.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="slide-card swiper-slide h-100">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Card title</strong></h5>
                                    <p class="card-text cut-text">Words in the woods are found anywhere in the world. Words
                                        in the woods are found around the world.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="slide-card swiper-slide h-100">
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Card title</strong></h5>
                                    <p class="card-text cut-text">Words in the woods are found anywhere in the world. Words
                                        in the woods are found around the world.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <div class="b-gray-divider"></div>

    <section class="bg-white">
        <div class="container py-5">
            <div class="container mt-5 mb-5">
                <h2 class="pb-2 border-bottom border-4 mt-5 mb-5"><strong>Featured</strong></h2>
            </div>
            <div class="row justify-content-center mb-5">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 mb-5">
                    <div class="col d-flex align-items-start">
                        <div
                            class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                            <i class="fas fa-microchip p-3"></i>
                        </div>
                        <div>
                            <h3 class="fs-2">Featured title</h3>
                            <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another
                                sentence and
                                probably just keep going until we run out of words.</p>
                            <a href="#" class="btn btn-primary">
                                Primary button
                            </a>
                        </div>
                    </div>
                    <div class="col d-flex align-items-start">
                        <div
                            class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                            <i class="fas fa-microchip p-3"></i>
                        </div>
                        <div>
                            <h3 class="fs-2">Featured title</h3>
                            <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another
                                sentence and
                                probably just keep going until we run out of words.</p>
                            <a href="#" class="btn btn-primary">
                                Primary button
                            </a>
                        </div>
                    </div>
                    <div class="col d-flex align-items-start">
                        <div
                            class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                            <i class="fas fa-microchip p-3"></i>
                        </div>
                        <div>
                            <h3 class="fs-2">Featured title</h3>
                            <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another
                                sentence and
                                probably just keep going until we run out of words.</p>
                            <a href="#" class="btn btn-primary">
                                Primary button
                            </a>
                        </div>
                    </div>
                    <div class="col d-flex align-items-start">
                        <div
                            class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                            <i class="fas fa-microchip p-3"></i>
                        </div>
                        <div>
                            <h3 class="fs-2">Featured title</h3>
                            <p>Paragraph of text beneath the heading to explain the heading. We'll add onto it with another
                                sentence and
                                probably just keep going until we run out of words.</p>
                            <a href="#" class="btn btn-primary">
                                Primary button
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="b-gray-divider"></div>

    <section class="py-5 bg-white">
        <div class="container mt-5 mb-5">
            <h2 class="pb-2 border-bottom border-4 mt-5 mb-5"><strong>Gallery</strong></h2>
        </div>
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 mb-5">
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('storage/images/3.jpg') }}" class="" alt="Image">
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('storage/images/3.jpg') }}" class="" alt="Image">
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('storage/images/3.jpg') }}" class="" alt="Image">
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('storage/images/3.jpg') }}" class="" alt="Image">
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('storage/images/3.jpg') }}" class="" alt="Image">
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('storage/images/3.jpg') }}" class="" alt="Image">
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('storage/images/3.jpg') }}" class="" alt="Image">
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('storage/images/3.jpg') }}" class="" alt="Image">
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('storage/images/3.jpg') }}" class="" alt="Image">
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="{{ asset('storage/images/3.jpg') }}" class="" alt="Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="b-gray-divider"></div>

    <section class="bg-white">
        <div class="container py-5">
            <div class="container mt-5 mb-5">
                <h2 class="pb-2 border-bottom border-4 mt-5 mb-5"><strong>Partners</strong></h2>
            </div>
            <div class="row justify-content-md-center mb-5">
                <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-4 mb-5">
                    <div class="col">
                        <a href="javascript:void(0)">
                            <img src="{{ asset('storage/logo/sys_logo.png') }}" width="150px" alt="Image">
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)">
                            <img src="{{ asset('storage/logo/sys_logo.png') }}" width="150px" alt="Image">
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)">
                            <img src="{{ asset('storage/logo/sys_logo.png') }}" width="150px" alt="Image">
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)">
                            <img src="{{ asset('storage/logo/sys_logo.png') }}" width="150px" alt="Image">
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)">
                            <img src="{{ asset('storage/logo/sys_logo.png') }}" width="150px" alt="Image">
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)">
                            <img src="{{ asset('storage/logo/sys_logo.png') }}" width="150px" alt="Image">
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)">
                            <img src="{{ asset('storage/logo/sys_logo.png') }}" width="150px" alt="Image">
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)">
                            <img src="{{ asset('storage/logo/sys_logo.png') }}" width="150px" alt="Image">
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)">
                            <img src="{{ asset('storage/logo/sys_logo.png') }}" width="150px" alt="Image">
                        </a>
                    </div>
                </div>
            </div>
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
