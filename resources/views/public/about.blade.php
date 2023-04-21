@extends('layouts.guest')

@section('title', 'About')

@section('styles')
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
    <div class="bg-dark text-secondary px-4 py-5 text-center" id="banner"
        style="background-image: url({{ asset('storage/logo/home_banner.jpg') }})">
        <div class="py-5">
            <h1 class="display-5 fw-bold text-white">About College of Information and <br> Communications Technology</h1>
        </div>
    </div>

    <section class="bg-white py-5" id="programs-offered">
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
                        <button class="btn btn-primary" id="read-more-bscs">Read More...</button>
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
                        <button class="btn btn-primary" id="read-more-bsis">Read More...</button>
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
                        <button class="btn btn-primary" id="read-more-bsit">Read More...</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container px-4 py-5" id="featured-3">
            <h2 class="pb-2 border-bottom border-4">Specific Profession/Carreers/Occupations for Graduates</h2>
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                <div class="feature col">
                    <div
                        class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3">
                        <i class="fas fa-microchip fs-1"></i>
                    </div>
                    <h3 class="fs-2">Bachelor of Science in Computer Science</h3>
                    <hr>
                    <h4 class="fs-3">Primary Job Roles</h4>
                    <ul>
                        <li>Software Engineer</li>
                        <li>Systems Software Developer</li>
                        <li>Applications Software Developer</li>
                        <li>Research and Development Computing Professional</li>
                        <li>Computer Programmer</li>
                    </ul>
                    <hr>
                    <h4 class="fs-3">Secondary Job Roles</h4>
                    <ul>
                        <li>Systems Analyst</li>
                        <li>Data Analyst</li>
                        <li>Quality Assurance Specialist</li>
                        <li>Software Support Specialist</li>
                    </ul>
                </div>
                <div class="feature col">
                    <div
                        class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3">
                        <i class="fas fa-microchip fs-1"></i>
                    </div>
                    <h3 class="fs-2">Bachelor of Science in Information System</h3>
                    <hr>
                    <h4 class="fs-3">Primary Job Roles</h4>
                    <ul>
                        <li>Organizational Process Analyst</li>
                        <li>Systems Analyst</li>
                        <li>Data Analyst</li>
                        <li>Solutions Specialist</li>
                        <li>IS Project Management Personnel</li>
                    </ul>
                    <hr>
                    <h4 class="fs-3">Secondary Job Roles</h4>
                    <ul>
                        <li>Applications Developer</li>
                        <li>End User Trainer</li>
                        <li>Documentation Specialist</li>
                        <li>Quality Assurance Specialist</li>
                    </ul>
                </div>
                <div class="feature col">
                    <div
                        class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3">
                        <i class="fas fa-microchip fs-1"></i>
                    </div>
                    <h3 class="fs-2">Bachelor of Science in Information Technology</h3>
                    <hr>
                    <h4 class="fs-3">Primary Job Roles</h4>
                    <ul>
                        <li>Web and Applications Developer</li>
                        <li>Systems Administrator</li>
                        <li>Junior Database Administrator</li>
                        <li>Junior Information Security Administrator</li>
                        <li>Network Engineer</li>
                        <li>Systems Integration Personnel</li>
                        <li>IT Audit Assistant</li>
                        <li>Technical Support Specialist</li>
                    </ul>
                    <hr>
                    <h4 class="fs-3">Secondary Job Roles</h4>
                    <ul>
                        <li>QA Specialist</li>
                        <li>Systems Analyst</li>
                        <li>Computer Programmer</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-5">
        <div class="container px-4 py-5" id="hanging-icons">
            <h2 class="pb-2 border-bottom border-4">Admission and Retention Policies for All Computing Programs</h2>
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-2">
                <div class="col d-flex align-items-start">
                    <div
                        class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                        <i class="fas fa-microchip fs-1"></i>
                    </div>
                    <div>
                        <h3 class="fs-2">A. Admission Policies</h3>
                        <p>An applicant to be admitted to the program should meet the following requirements:</p>
                        <ul>
                            <li>General Weighted Average (GWA) of 83% or better or its equivalent in High School; and</li>
                            <li>No grade lower than 80% or its equivalent in the final grade in any subject</li>
                        </ul>
                        <p>The applicant qualifies to the program as determined by the College based on the following
                            criteria:</p>
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">Criteria</th>
                                    <th scope="col"></th>
                                    <th scope="col">Weight</th>
                                </tr>
                            </thead>
                            <tbody class="table-secondary">
                                <tr>
                                    <td>A</td>
                                    <td>General Weighted Average (GWA)</td>
                                    <td>15%</td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>Differential Aptitude Test</td>
                                    <td>25%</td>
                                </tr>
                                <tr>
                                    <th scope="row">DAT Result</th>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>Interview</td>
                                    <td>10%</td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>Written Exam</td>
                                    <td>50%</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total</th>
                                    <td></td>
                                    <th scope="row">100%</th>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <h4 class="fs-4"><i>For Transferees</i></h4>
                        <p>A Transferee to be admitted to the program should have a GWA of 2.7 or better or its equivalent.
                        </p>
                        <hr>
                        <h4 class="fs-4"><i>For Shifters</i></h4>
                        <p>Upon approval of the application to shift to another program, the shifter shall be subjected to
                            the requirement for the transferee.</p>
                    </div>
                </div>

                <div class="col d-flex align-items-start">
                    <div
                        class="icon-square text-bg-light d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                        <i class="fas fa-microchip fs-1"></i>
                    </div>
                    <div>
                        <h3 class="fs-2">B. Retention Policies</h3>
                        <p>A student shall be allowed to continue in the program subject to the following requirements:</p>
                        <ul>
                            <li>General Weighted Average of 2.7 or better in the preceding semester; and</li>
                            <li>Failed Information Technology core, professional or elective course be re-enrolled only once
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5" id="faculty">
        <div class="container px-4 py-5" id="hanging-icons">
            <h2 class="pb-2 border-bottom border-4">Faculty</h2>
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-1">
                <div class="col d-flex align-items-start" id="content">
                    <div class="mb-2">
                        <img src="{{ asset('storage/images/faculty/faculty_1.png') }}"
                            class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
                            alt="">
                    </div>
                </div>
                <div class="col d-flex align-items-start" id="content">
                    <div class="mb-2">
                        <img src="{{ asset('storage/images/faculty/faculty_2.png') }}"
                            class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
                            alt="">
                    </div>
                </div>
                <div class="col d-flex align-items-start" id="content">
                    <div class="mb-2">
                        <img src="{{ asset('storage/images/faculty/faculty_3.png') }}"
                            class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#read-more-bscs').click(function(e) {
                // console.log(e);
                e.preventDefault();

                const content = document.getElementById('content-bscs');

                $(content).toggleClass('show');
                const isReadMore = $(content).hasClass('show');
                if (isReadMore) {
                    $(this).text("Show Less");
                } else {
                    $(this).text("Read More...");
                }
            });

            $('#read-more-bsis').click(function(e) {
                // console.log(e);
                e.preventDefault();
                const content = document.getElementById('content-bsis');

                $(content).toggleClass('show');
                const isReadMore = $(content).hasClass('show');
                if (isReadMore) {
                    $(this).text("Show Less");
                } else {
                    $(this).text("Read More...");
                }
            });

            $('#read-more-bsit').click(function(e) {
                // console.log(e);
                e.preventDefault();

                const content = document.getElementById('content-bsit');

                $(content).toggleClass('show');
                const isReadMore = $(content).hasClass('show');
                if (isReadMore) {
                    $(this).text("Show Less");
                } else {
                    $(this).text("Read More...");
                }
            });
        });
    </script>
@endsection
