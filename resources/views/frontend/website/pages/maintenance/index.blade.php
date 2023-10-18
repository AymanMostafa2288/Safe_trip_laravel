@extends('frontend.website.layouts.index')
@section('page_content')
<section class="error-area">
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="error-content">
                    <img src="{{ readFileStorage(appSettings('app_logo')) }}" style="width: auto" alt="error">
                    <h3>{{ appendToLanguage($lang_slug, 'content', 'Website Under Maintenance') }}</h3>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
