@extends('frontend.website.layouts.index')
@section('page_content')

        @if (count($sliders) > 0)
            <!-- Start Main Banner Area -->
            <div class="home-slides owl-carousel owl-theme ">
                @component('frontend.website.component.slider',['sliders'=>$sliders])
                @endcomponent

            </div>
            <!-- End Main Banner Area -->
        @endif

        @if (count($services) > 0)
            <!-- Start Services Area -->
            <section class="services-area ptb-100 bg-f4f9fd">
                <div class="container">
                    <div class="section-title">
                        <h2>{{ appendToLanguage($lang_slug,'content','Our Services') }}</h2>
                    </div>

                    <div class="row">

                        @component('frontend.website.component.service',['services'=>$services,'lang_slug'=>$lang_slug])
                        @endcomponent



                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="more-services-btn">
                                <a href="{{ route(env('APP_MODE').'.services-page') }}" class="btn btn-primary">{{ appendToLanguage($lang_slug,'content','More Services') }} <i class="flaticon-right-chevron"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Services Area -->
        @endif

        <!-- Start About Area -->
        <section class="about-area">
            <div class="container-fluid p-0">
                <div class="row m-0">
                    <div class="col-lg-6 col-md-12 p-0">
                        <div class="about-image" style="background-image:url({{ readFileStorage(appSettings('about_us_image')) }})">
                            <img src="{{ readFileStorage(appSettings('about_us_image')) }}" alt="image" style="width:auto">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 p-0">
                        <div class="about-content">
                            <span>{{ appendToLanguage($lang_slug,'content','About Us') }}</span>
                            <h2>{{ appendToLanguage($lang_slug,'content','Short Story') }}</h2>
                            <p>{{ appSettings('about_us_'.$lang_slug) }}</p>

                            <a href="{{ route(env('APP_MODE').'.about-page') }}" class="btn btn-primary">{{ appendToLanguage($lang_slug,'content','Learn More') }} <i class="flaticon-right-chevron"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End About Area -->

        <!-- Start Our Mission Area -->
        <section class="our-mission-area ptb-100">
            <div class="container-fluid p-0">
                <div class="row m-0">
                    <div class="col-lg-6 col-md-12 p-0">
                        <div class="our-mission-content">
                            <span class="sub-title">{{ appendToLanguage($lang_slug,'content','Our Vision') }}</span>
                            <h2>{{ appendToLanguage($lang_slug,'content','Better Information, Better Health') }}</h2>
                            <p>{{ appSettings('mission_'.$lang_slug) }}</p>


                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 p-0">
                        <div class="our-mission-image" style="background-image:url({{ readFileStorage(appSettings('vision_image')) }})">
                            <img src="{{ readFileStorage(appSettings('vision_image')) }}" style="width: auto" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Our Mission Area -->

        <!-- Start Fun Facts Area -->
        <section class="fun-facts-area ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="single-fun-facts">
                            <div class="icon">
                                <i class="flaticon-doctor-1"></i>
                            </div>
							<h3>
                                <span class="odometer" data-count="{{ appSettings('export_doctore_counter') }}"></span>
                                <span class="optional-icon">+</span>
                            </h3>
                            <p>Expert Doctors</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="single-fun-facts">
                            <div class="icon">
                                <i class="flaticon-light-bulb"></i>
                            </div>
							<h3>
                                <span class="odometer" data-count="{{ appSettings('problem_solve_counter') }}"></span>
                                <span class="optional-icon">K</span>
                            </h3>
                            <p>Problem Solve</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="single-fun-facts">
                            <div class="icon">
                                <i class="flaticon-science"></i>
                            </div>
							<h3>
                                <span class="odometer" data-count="{{ appSettings('award_winning_counter') }}"></span>
                                <span class="optional-icon">+</span>
                            </h3>
                            <p>Award Winning</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="single-fun-facts">
                            <div class="icon">
                                <i class="flaticon-trophy"></i>
                            </div>
							<h3>
                                <span class="odometer" data-count="{{ appSettings('experiences_counter') }}"></span>
                                <span class="optional-icon">K</span>
                            </h3>
                            <p>Experiences</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Fun Facts Area -->

        @if (count($faqs) > 0)
            <!-- Start FAQ Area -->
            <section class="faq-area">
                <div class="container-fluid p-0">
                    <div class="row m-0">
                        <div class="col-lg-6 col-md-12 p-0">
                            <div class="faq-image" style="background-image:url({{ readFileStorage(appSettings('faq_image')) }})">
                                <img src="{{ readFileStorage(appSettings('faq_image')) }}" style="width: auto" alt="image">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 p-0">
                            <div class="faq-accordion">
                                <span class="sub-title">{{ appendToLanguage($lang_slug,'content','Frequently Asked Questions') }}</span>
                                <ul class="accordion">
                                    @component('frontend.website.component.faq',['faqs'=>$faqs])
                                    @endcomponent

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End FAQ Area -->
        @endif


        @if (count($partners) > 0)
            <!-- Start Partner Area -->
            <section class="partner-area ptb-100 bg-f4f9fd">
                <div class="container">
                    <div class="section-title">
                        <h2>{{ appendToLanguage($lang_slug,'content','Featured Customers & Partners') }}</h2>
                    </div>
                    <div class="customers-partner-list">
                        @component('frontend.website.component.partner',['partners'=>$partners])
                        @endcomponent
                    </div>
                </div>
            </section>
            <!-- End Partner Area -->
        @endif

        @if (count($blogs) > 0)
            <!-- Start Blog Area -->
            <section class="blog-area ptb-100">
                <div class="container">
                    <div class="section-title">
                        <span>{{ appendToLanguage($lang_slug,'content','News & Blog') }}</span>
                        <h2>{{ appendToLanguage($lang_slug,'content','The News from Our Blog') }}</h2>
                    </div>

                    <div class="row">
                        @component('frontend.website.component.blog',['blogs'=>$blogs])
                        @endcomponent
                    </div>
                </div>
            </section>
            <!-- End Blog Area -->
        @endif


@endsection
