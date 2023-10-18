     <!-- Preloader -->
     <div class="preloader">
        <div class="loader">
            <div class="loader-outter"></div>
            <div class="loader-inner"></div>

            <div class="indicator">
                <svg width="16px" height="12px">
                    <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                    <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                </svg>
            </div>
        </div>
    </div>
    <!-- End Preloader -->

    <!-- Start Header Area -->
    <header class="header-area">
        <div class="top-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <ul class="header-contact-info">
                            <li><i class="far fa-clock"></i>{{ appSettings('workes_time_ar') }}</li>
                            <li><i class="fas fa-phone"></i> {{ appendToLanguage($lang_slug,'content','Call Us') }}: <a href="tel:{{ appSettings('telephone') }}">{{ appSettings('telephone') }}</a></li>
                            <li><i class="far fa-paper-plane"></i> <a href="mailto:{{ appSettings('email') }}"><span>{{ appSettings('email') }}</span></a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4">
                        <div class="header-right-content">
                            <ul class="top-header-social">
                                <li><a href="{{ appSettings('facebook') }}"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="{{ appSettings('twitter') }}"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="{{ appSettings('linkedin') }}"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="{{ appSettings('instgram') }}"><i class="fab fa-instagram"></i></a></li>
                            </ul>

                            <div class="lang-select">
                                <select onchange="location.href = '{{ $another_lang_url }}'">
                                    @if ($lang_slug=='ar')
                                    <option>English</option>
                                    @else
                                    <option>العربية</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Navbar Area -->
        <div class="navbar-area">
            <div class="fovia-responsive-nav">
                <div class="container">
                    <div class="fovia-responsive-menu">
                        <div class="logo">
                            <a href="index.html">
                                <img src="{{ readFileStorage(appSettings('app_logo')) }}" alt="logo">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @include('frontend.website.layouts.menu')
        </div>
        <!-- End Navbar Area -->
    </header>
    <!-- End Header Area -->
