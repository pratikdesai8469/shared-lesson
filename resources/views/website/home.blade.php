@extends('layouts.website.main')

@section('content')



<!-- hero area -->
<section>
    <div class="hero-slider-2 position-relative">
        <video  autoplay muted loop id="videoSlide">
            <source src="{{asset('public/website/images/bg-video.mp4')}}" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
          
        <!-- hero slider item -->
        {{-- <div class="hero-slider-item py-160" style="background-image: url({{ asset('public/website/images/banner/slider1.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="hero-content">
                            <h4 class="text-uppercase mb-1" data-duration-in=".5" data-animation-in="fadeInLeft" data-delay-in=".1">We are here to</h4>
                            <h1 class="font-weight-bold mb-3" data-duration-in=".5" data-animation-in="fadeInLeft" data-delay-in=".5">Lesson Plan</h1>
                            <p class="text-dark mb-50" data-duration-in=".5" data-animation-in="fadeInLeft" data-delay-in=".9">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                <br> incididunt ut labore et dolore magna aliqua.
                            </p>
                            <!-- <a data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in="1.3" href="#" class="btn btn-outline text-uppercase">more details</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hero slider item -->
        <div class="hero-slider-item py-160" style="background-image: url({{ asset('public/website/images/banner/slider2.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="hero-content">
                            <h4 class="text-uppercase mb-1" data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".1">Get your</h4>
                            <h1 class="font-weight-bold mb-3" data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".5">Consult a mentor</h1>
                            <p class="text-dark mb-50" data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".9">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                <br> incididunt ut labore et dolore magna aliqua.
                            </p>
                            <!-- <a data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in="1.3" href="#" class="btn btn-outline text-uppercase">more details</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hero slider item -->
        <div class="hero-slider-item py-160" style="background-image: url({{ asset('public/website/images/banner/slider3.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="hero-content">
                            <h4 class="text-uppercase mb-1" data-duration-in=".5" data-animation-in="fadeInLeft" data-delay-in=".1">Start your</h4>
                            <h1 class="font-weight-bold mb-3" data-duration-in=".5" data-animation-in="fadeInLeft" data-delay-in=".5">Unit Plan</h1>
                            <p class="text-dark mb-50" data-duration-in=".5" data-animation-in="fadeInLeft" data-delay-in=".9">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                <br> incididunt ut labore et dolore magna aliqua.
                            </p>
                            <!-- <a data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in="1.3" href="#" class="btn btn-outline text-uppercase">more details</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hero slider item -->
        <div class="hero-slider-item py-160" style="background-image: url({{ asset('public/website/images/banner/slider4.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="hero-content">
                            <h4 class="text-uppercase mb-1" data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".1">We are always</h4>
                            <h1 class="font-weight-bold mb-3" data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".5">Be Inspired By Best</h1>
                            <p class="text-dark mb-50" data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".9">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                <br> incididunt ut labore et dolore magna aliqua.
                            </p>
                            <!-- <a data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in="1.3" href="#" class="btn btn-outline text-uppercase">more details</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hero slider item -->
        <div class="hero-slider-item py-160" style="background-image: url({{ asset('public/website/images/banner/slider5.jpg') }});">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="hero-content">
                            <h4 class="text-uppercase mb-1" data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".1">Make lesson planning</h4>
                            <h1 class="font-weight-bold mb-3" data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".5">Easy And Fun</h1>
                            <p class="text-dark mb-50" data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in=".9">
                                <br><br>
                            </p>
                            <!-- <a data-duration-in=".5" data-animation-in="fadeInDown" data-delay-in="1.3" href="#" class="btn btn-outline text-uppercase">more details</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</section>
<!-- /hero-area -->

<!-- cta -->
<!-- <section class="bg-primary py-4 text-center text-lg-left">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 align-self-center">
                <h3 class="text-white">Lesson Planner give the smart solution for your business</h3>
            </div>
            <div class="col-lg-3 text-lg-right">
                <a href="#" class="btn btn-light btn-sm">GET AN QUOTE</a>
            </div>
        </div>
    </div>
</section> -->
<!-- /cta -->

{{-- <br><br>
<section class="fun-facts overlay-dark section-sm" style="background-image: url({{ asset('public/website/images/background/cta.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0">
                <div class="d-flex flex-sm-row flex-column justify-content-lg-center align-items-center text-center text-sm-left">
                    <i class="round-icon ti-server mr-sm-3 mr-0 mb-3 mb-sm-0"></i>
                    <div class="text-center text-sm-left">
                        <h2 class="count text-white mb-0" data-count="50">0</h2>
                        <p class="text-white mb-0">Teachers</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0">
                <div class="d-flex flex-sm-row flex-column justify-content-lg-center align-items-center text-center text-sm-left">
                    <i class="round-icon ti-face-smile mr-sm-3 mr-0 mb-3 mb-sm-0"></i>
                    <div class="text-center text-sm-left">
                        <h2 class="count text-white mb-0" data-count="2900">0</h2>
                        <p class="text-white mb-0">Satisfied Student</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0">
                <div class="d-flex flex-sm-row flex-column justify-content-lg-center align-items-center text-center text-sm-left">
                    <i class="round-icon ti-thumb-up mr-sm-3 mr-0 mb-3 mb-sm-0"></i>
                    <div class="text-center text-sm-left">
                        <h2 class="count text-white mb-0" data-count="580">0</h2>
                        <p class="text-white mb-0">Cup Of Coffee</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0">
                <div class="d-flex flex-sm-row flex-column justify-content-lg-center align-items-center text-center text-sm-left">
                    <i class="round-icon ti-cup mr-sm-3 mr-0 mb-3 mb-sm-0"></i>
                    <div class="text-center text-sm-left">
                        <h2 class="count text-white mb-0" data-count="130">0</h2>
                        <p class="text-white mb-0">Awards Win</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<!-- about -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-content">
                    <h5 class="section-title-sm">About Us</h5>
                    <h3 class="section-title section-title-border-half">Who We Are?</h3>
                    <p class="text-dark">
                        Welcome to <strong>SharedLessons</strong><br>
                        Make the lesson planning process easier and smoother.
                        <br><br>
                        <strong>SharedLessons</strong> provides teachers with digital applications and platforms that improves accuracy, efficiency and sophistication of the lesson planning process..
                    </p>
                    <div class="about-item">
                        <ul class="pl-0 d-inline-block float-sm-left mr-sm-5">
                            <li class="font-secondary text-color mb-10">
                                <i class="text-primary mr-2 ti-arrow-circle-right"></i>Lesson planning</li>
                            <li class="font-secondary text-color mb-10">
                                <i class="text-primary mr-2 ti-arrow-circle-right"></i>Sharing lessons</li>
                        </ul>
                        <ul class="d-inline-block pl-0">
                            <li class="font-secondary text-color mb-10">
                                <i class="text-primary mr-2 ti-arrow-circle-right"></i>Planning with other educators</li>
                            <li class="font-secondary text-color mb-10">
                                <i class="text-primary mr-2 ti-arrow-circle-right"></i>Saving lessons in categories</li>
                        </ul>
                    </div>
                    {{-- <a href="#" class="btn btn-primary mb-md-50 mt-4">Contact Us</a> --}}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-slider">
                    <img class="img-fluid" src="{{ asset('public/website/images/about/about-1.jpg') }}" alt="about-image">
                    <img class="img-fluid" src="{{ asset('public/website/images/about/about-2.jpg') }}" alt="about-image">
                    <img class="img-fluid" src="{{ asset('public/website/images/about/about-3.jpg') }}" alt="about-image">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /about -->

<section class="cta overlay-dark section-sm" style="background-image: url({{ asset('public/website/images/background/cta-2.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3 class="text-white mb-20">Smart planning solutions for educators</h3>
                <!-- <a href="#" class="btn btn-light">View more</a> -->
            </div>
        </div>
    </div>
</section> 



<section class="section">
    <div class="container col-lg-5">
        <div class="row p-5 text-center rounded box-shadow">
            <div class="col-lg-12">
                <h3 class="section-title-sm ">Download Now</h3>
            </div>
            <div class="col-lg-6 col-sm-12">
                <img src="{{ asset('public/website/images/play-store.png') }}" height="80px" width="200px">
            </div>
            <div class="col-lg-6 col-sm-12" style="margin-top: 12px;">
                <img src="{{ asset('public/website/images/app-store.png') }}" height="53px" width="175px">
            </div>
        </div>
    </div>
</section>

@endsection
