@extends('layout.app')
@section('content')
    <div class="container">
        <!-- ======= Hero Section ======= -->
        <section id="hero" class="hero d-flex align-items-center">

            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-center">
                        <h1 data-aos="fade-up">SITC Campus</h1>
                        <h2 data-aos="fade-up" data-aos-delay="400">Campus of Pioneering Advanced Knowledge
                            and Reaching Advancements in Your Career</h2>
                        <div data-aos="fade-up" data-aos-delay="600">
                            <div class="text-center text-lg-start">
                                <a href="/signup"
                                   class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Register at SITC</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                        <img src="{{asset('/img/hero-img.png')}}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>

        </section><!-- End Hero -->

        <main id="main">
            <!-- ======= About Section ======= -->
            <section id="about" class="about">

                <div class="container" data-aos="fade-up">
                    <div class="row gx-0">

                        <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up"
                             data-aos-delay="200">
                            <div class="content">
                                <h3>Who We Are</h3>
                                <h2>Established in year 2005, SITC is among the leading tertiary education providers in
                                    Sri Lanka with the largest number of students in the private sector higher education
                                    industry.</h2>
                                <p>
                                    Popularly known as SITC Campus, SITC offers Certificate level programs,
                                    Diplomas, Higher Diplomas in association with leading Universities and educational
                                    service providers in Sri Lanka.
                                </p>
                                <div class="text-center text-lg-start">
                                    <a href="https://sitc.lk"
                                       class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                                        <span>Learn More</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                            <img src="{{asset('/img/hero-img.png')}}" class="img-fluid" alt="">
                        </div>

                    </div>
                </div>

            </section><!-- End About Section -->
        </main><!-- End #main -->
    </div>
@endsection
