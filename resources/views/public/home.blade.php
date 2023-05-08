@extends('layouts.guest')

@section('title', 'Home')

@section('content')
    <div class="bg-dark text-secondary px-4 py-5 text-center mb-5" id="banner"
        style="background-image: url({{ asset('storage/logo/site_banner.png') }})">
        <div class="py-5">
            <h1 class="display-5 fw-bold text-white">Catanduanes State University <br> College of Information and <br>
                Communications Technology</h1>
        </div>
    </div>

    <section id="home" class="">

        <div class="p-lg-5 p-3">
            <div class="row">
                <div class="col-md-5 order-md-1 mt-3">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('storage/images/1.jpg') }}" class="d-block w-100" alt="Image">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('storage/images/2.jpg') }}" class="d-block w-100" alt="Image">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('storage/images/3.jpg') }}" class="d-block w-100" alt="Image">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-md-7 order-md-2 mt-3 mt-lg-5">
                    <h2 class=" fw-normal lh-1">College of Information and Communications Technology</h2>
                    <p class="lead">
                    <ol>
                        <li>Provide students with knowledge, hands-on experience and application of theory regarding
                            Information Technology issues.</li>
                        <li>Educate students in the sciences and practices of Information Technology (IT).</li>
                        <li>Provide educational breadth and depth in the study of (IT).</li>
                        <li>Let the students gain knowledge on how to use enterprise-scale network and development
                            technology.</li>
                        <li>Produce graduates with skills in software development along with an understanding of the role of
                            software systems within the business.</li>
                        <li>Produce graduates ready to function in Information Systems positions with the competencies,
                            skills and attitudes necessary for success in the workplace.</li>
                    </ol>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="container px-4 py-5" id="hanging-icons">
            <h2 class="pb-2 border-bottom border-4">Programs Offered</h2>
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                <div class="col d-flex align-items-start" id="content">
                    <div
                        class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                        <i class="fas fa-microchip fs-1"></i>
                    </div>
                    <div>
                        <h3 class="fs-2">Bachelor of Science in Computer Science</h3>
                        <p>
                            The BS Computer Science program includes the study of computing concepts and theories,
                            algorithmic
                            foundations and new developments in computing. The program prepares students to design and
                            create
                            algorithmically complex software and develop new effective algorithms for solving computing
                            problems.
                            <span class="collapse" id="content-bscs">
                                <br><br>
                                The program also includes the study of the standards and practices in Software Engineering.
                                It
                                prepares students to acquire skills and disciplines required for designing, writing, and
                                modifying
                                software components, modules and applications that comprise software solutions.
                            </span>
                        </p>
                        <a href="{{ route('public-about') }}#programs-offered" class="btn btn-primary">Read More...</a>
                    </div>
                </div>
                <div class="col d-flex align-items-start" id="content">
                    <div
                        class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                        <i class="fas fa-microchip fs-1"></i>
                    </div>
                    <div>
                        <h3 class="fs-2">Bachelor of Science in Information System</h3>
                        <p>
                            The BS Information Systems Program includes the study of application and effect of information
                            technology to organizations. Graduates of the program should be able to implement an information
                            system, which considers the complex technological and organizational factors affecting it. These
                            include components, tools, techniques, strategies, methodologies, etc.
                            <span class="collapse" id="content-bsis">
                                <br> <br>
                                Graduates are able to help an organization determine how information and technology-enabled
                                business
                                processess can be used as strategic tool to achieve a competitive advantage. As a result, IS
                                professionals require a sound understanding of organizational principles and practices so
                                that
                                they
                                can serve as an effective bridge between the technical and management/users communities
                                within
                                an
                                organization. This enables them to ensure that the organization has the information and the
                                systems
                                it needs to support its operations.
                            </span>
                        </p>
                        <a href="{{ route('public-about') }}#programs-offered" class="btn btn-primary">Read More...</a>
                    </div>
                </div>
                <div class="col d-flex align-items-start">
                    <div
                        class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                        <i class="fas fa-microchip fs-1"></i>
                    </div>
                    <div>
                        <h3 class="fs-2">Bachelor of Science in Information Technology</h3>
                        <p>
                            The BS Information Technology program includes the study of the utilization of both hardware and
                            software technologies involving planning, installing, customizing, operating, managing and
                            administering, and maintaining information technology infrastructure that provides computing
                            solutions to address the needs of an organization.
                            <span class="collapse" id="content-bsit">
                                <br><br>
                                The program prepares graduates to address various user needs involving the selection,
                                development,
                                application, integration and management of computing technologies within an organization.
                            </span>
                        </p>
                        <a href="{{ route('public-about') }}#programs-offered" class="btn btn-primary">Read More...</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light">
        <div class="container px-4 py-5" id="hanging-icons">
            <h2 class="pb-2 border-bottom border-4">Faculty</h2>
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-1">
                <div class="col d-flex align-items-start" id="content">
                    <div>
                        <img src="{{ asset('storage/images/faculty/faculty_1.png') }}"
                            class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
                            alt="">
                        <div class="text-center mt-4">
                            <a href="{{ route('public-about') }}#faculty" class="btn btn-primary fs-4">See
                                More...</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection
