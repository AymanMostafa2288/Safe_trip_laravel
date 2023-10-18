@extends('backend.layouts.'.config('var.dashboard_theme').'.index')

@section('style_url')
@endsection
@section('style_in_page')
@endsection
@section('script_url')
@endsection
@section('script_in_page')

<script>
	jQuery(document).ready(function() {
	   Metronic.init(); // init metronic core componets
	   Layout.init(); // init layout
	   Demo.init(); // init demo features
	   FormSamples.init();
	   TableManaged.init();
		// Index.init(); // init index page
	 	Tasks.initDashboardWidget(); // init tash dashboard widget

	});
</script>
@endsection
@section('page_title')
<title>{{ appSettings('app_name') }} | {{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$config['main_title']) }}</title>
@endsection
@section('page_content')
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
		<!-- BEGIN PAGE HEAD -->
		<div class="page-head">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				{{-- <h1>{{ $config['main_title'] }}</h1> <small>{{ $config['sub_title'] }}</small></h1> --}}
                <h1>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$config['main_title']) }}</h1></h1>
			</div>
			<!-- END PAGE TITLE -->
		</div>
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<a href="{{ route('main_dashboard') }}">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Dashboard') }}</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				<a>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$config['main_title']) }}</a>
				<i class="fa fa-circle"></i>
			</li>
			@foreach ($config['breadcrumb'] as $breadcrumb)
                @if(array_key_exists('query_builder',$breadcrumb) && !empty($breadcrumb['query_builder']))
                    @php
                        $sting_query='';
                        foreach ($breadcrumb['query_builder'] as $key => $value) {
                            $sting_query='?'.$key.'='.$value;
                        }
                    @endphp
                @else
                    @php
                        $sting_query='';
                    @endphp
                @endif
			<li><a href="{{ route($breadcrumb['route']) }}{{ $sting_query }}">
                {{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$breadcrumb['title']) }}
            </a></li>
			@endforeach
		</ul>
		<!-- END PAGE HEAD -->
		<!-- BEGIN PAGE CONTENT INNER -->
		<div class="row margin-top-10">
			{!! $table !!}
		</div>

		<!-- END PAGE CONTENT INNER -->
	</div>
</div>
<!-- END CONTENT -->
@endsection

