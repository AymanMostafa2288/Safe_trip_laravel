<!doctype html>
<html lang="{{ $lang_slug }}"  dir="{{ ($lang_slug=='ar' ?'rtl':'ltr' ) }}">

<!-- Mirrored from templates.envytheme.com/fovia/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 27 Jan 2023 09:45:27 GMT -->
    <head>
        <!-- Required meta tags -->


        <link rel="icon" type="image/png" href="{{ readFileStorage(appSettings('app_favicon')) }}">
        <title>{{ appendToLanguage($lang_slug,'content',appSettings('app_name')) }} | {{ $seo['page_h1'] }}</title>

        @include('frontend.website.headers.meta')

        @include('frontend.website.headers.head',['lang_slug'=>$lang_slug])

    </head>
<body>
    @include('frontend.website.headers.index')
    @yield('page_content')
    @include('frontend.website.footer.index')
</body>

<!-- Mirrored from templates.envytheme.com/fovia/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 27 Jan 2023 09:46:05 GMT -->
</html>
