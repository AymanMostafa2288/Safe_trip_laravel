@extends('backend.layouts.' . config('var.dashboard_theme') . '.index')

@section('style_url')
    <link rel="stylesheet" type="text/css"
        href="{{ config('var.dashboard_theme_dist') }}global/plugins/clockface/css/clockface.css" />
    <link rel="stylesheet" type="text/css"
        href="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-datepicker/css/datepicker3.css" />
    <link rel="stylesheet" type="text/css"
        href="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" />
    <link rel="stylesheet" type="text/css"
        href="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-colorpicker/css/colorpicker.css" />
    <link rel="stylesheet" type="text/css"
        href="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" />
    <link rel="stylesheet" type="text/css"
        href="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css"
        href="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-summernote/summernote.css">
@endsection
@section('style_in_page')
    @if (array_key_exists('custom_js_and_styles', $config) &&
            array_key_exists('css', $config['custom_js_and_styles']) &&
            !empty($config['custom_js_and_styles']['css']))
        @foreach ($config['custom_js_and_styles']['css'] as $page_css)
            <link href="{{ config('var.dashboard_theme_dist') }}custom/css/{{ $page_css }}.css" rel="stylesheet"
                type="text/css" />
        @endforeach
    @endif
@endsection
@section('script_url')
    <script type="text/javascript"
        src="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js">
    </script>
    <script type="text/javascript"
        src="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js">
    </script>
    <script type="text/javascript" src="{{ config('var.dashboard_theme_dist') }}global/plugins/clockface/js/clockface.js">
    </script>
    <script type="text/javascript"
        src="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript"
        src="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript"
        src="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js">
    </script>
    <script type="text/javascript"
        src="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="{{ config('var.dashboard_theme_dist') }}admin/pages/scripts/components-pickers.js"></script>

    <script src="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-summernote/summernote.min.js"
        type="text/javascript"></script>
    <script src="{{ config('var.dashboard_theme_dist') }}admin/pages/scripts/components-editors.js"></script>
@endsection
@section('script_in_page')
    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
            Demo.init(); // init demo features
            FormSamples.init();
            Index.init(); // init index page
            Tasks.initDashboardWidget(); // init tash dashboard widget
            ComponentsPickers.init();
            ComponentsEditors.init();
            if ($("#multi_upload").length > 0) {
                $("#multi_upload").pekeUpload();
            }
        });
        $('select[readonly="readonly"] option:not(:selected)').attr('disabled', true);
    </script>
@endsection
@section('script_in_page_custom')

    @if (array_key_exists('custom_js_and_styles', $config) &&
            array_key_exists('js', $config['custom_js_and_styles']) &&
            !empty($config['custom_js_and_styles']['js']))
        @foreach ($config['custom_js_and_styles']['js'] as $page_js)
            <script src="{{ config('var.dashboard_theme_dist') }}custom/js/{{ $page_js }}.js" type="text/javascript">
            </script>
        @endforeach
    @endif
@endsection
@section('page_title')
    <title>{{ appSettings('app_name') }} |
        {{ appendToLanguage(getDashboardCurrantLanguage(), 'globals', $config['main_title']) }}</title>
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
                    <h1>{{ appendToLanguage(getDashboardCurrantLanguage(), 'globals', $config['main_title']) }}</h1>
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="{{ route('main_dashboard') }}">
                        {{ appendToLanguage(getDashboardCurrantLanguage(), 'globals', 'Dashboard') }}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a>{{ appendToLanguage(getDashboardCurrantLanguage(), 'globals', $config['main_title']) }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                @foreach ($config['breadcrumb'] as $breadcrumb)
                    @if (array_key_exists('query_builder', $breadcrumb) && !empty($breadcrumb['query_builder']))
                        @php
                            $sting_query = '';
                            foreach ($breadcrumb['query_builder'] as $key => $value) {
                                $sting_query = '?' . $key . '=' . $value;
                            }
                        @endphp
                    @else
                        @php
                            $sting_query = '';
                        @endphp
                    @endif
                    <li><a
                            href="{{ route($breadcrumb['route'], $breadcrumb['params']) }}{{ $sting_query }}">{{ appendToLanguage(getDashboardCurrantLanguage(), 'globals', $breadcrumb['title']) }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                @endforeach
            </ul>
            <!-- END PAGE BREADCRUMB -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="row margin-top-10">
                <div class="col-md-12">
                    <div class="portlet box purple">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>Default Pills
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse" data-original-title="" title="">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-pills">
								<li class="active">
									<a href="#data" data-toggle="tab" aria-expanded="true">
									Data </a>
								</li>
								<li >
									<a href="#reports" data-toggle="tab" aria-expanded="false">
									Reports </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="data">

                                    <div class="portlet light">
                                        <div class="portlet-body" style="background-color: #ccc">
                                            <div class="tabbable">
                                                {!! $form !!}
                                            </div>
                                        </div>
                                    </div>
								</div>
								<div class="tab-pane fade " id="reports">
									<div class="portlet light">
                                        <div class="portlet-body">
                                            <div class="tabbable">

                                            </div>
                                        </div>
                                    </div>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>

            <!-- END PAGE CONTENT INNER -->
        </div>
    </div>
    <!-- END CONTENT -->
@endsection
