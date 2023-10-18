<div class="fovia-nav">
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-light">
            <a class="navbar-brand" href="index.html">
                <img src="{{ readFileStorage(appSettings('app_logo')) }}" alt="logo">
            </a>
            @if (request()->route()->getPrefix()!='')
            <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="{{ route(env('APP_MODE').'.home-page') }}" class="nav-link active">{{ appendToLanguage($lang_slug,'content','Home') }}</a></li>
                    <li class="nav-item"><a href="{{ route(env('APP_MODE').'.about-page') }}" class="nav-link active">{{ appendToLanguage($lang_slug,'content','About') }}</a></li>
                    <li class="nav-item"><a href="{{ route(env('APP_MODE').'.services-page') }}" class="nav-link active">{{ appendToLanguage($lang_slug,'content','Services') }}</a></li>
                    <li class="nav-item"><a href="{{ route(env('APP_MODE').'.blogs-page') }}" class="nav-link active">{{ appendToLanguage($lang_slug,'content','Blogs') }}</a></li>
                    <li class="nav-item"><a href="{{ route(env('APP_MODE').'.contacts-page') }}" class="nav-link active">{{ appendToLanguage($lang_slug,'content','Contact Us') }}</a></li>

                </ul>
            </div>
            @endif

        </nav>
    </div>
</div>
