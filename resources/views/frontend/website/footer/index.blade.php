<!-- Start Footer Area -->
<section class="footer-area">
    <div class="container">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12" style="text-align: center;">
                <div class="single-footer-widget">
                    <div class="logo">
                        <a href="#"><img src="{{ readFileStorage(appSettings('app_logo')) }}" alt="image"></a>
                        <p>{{ appSettings('footer_'.$lang_slug) }}</p>
                    </div>

                    <ul class="social">
                        <li><a href="{{ appSettings('facebook') }}"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="{{ appSettings('twitter') }}"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="{{ appSettings('linkedin') }}"><i class="fab fa-linkedin-in"></i></a></li>
                        <li><a href="{{ appSettings('instgram') }}"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>


        </div>
    </div>
</section>
<!-- End Footer Area -->
<div class="go-top"><i class="fas fa-chevron-up"></i></div>

@include('frontend.website.footer.script')
