@extends('backend.layouts.'.config('var.dashboard_theme').'.index')

@section('style_url')
    <link href="{{ config('var.dashboard_theme_dist') }}assets/admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
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
@section('page_content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>New User Profile <small>user profile page sample</small></h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Pages</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">New User Profile</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-4" style="width: 22%">
                <div class="profile-sidebar" style="width: 250px;">
                    <!-- PORTLET MAIN -->
                    <div class="portlet light profile-sidebar-portlet">
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li class="active">
                                    <a href="extra_profile.html">
                                    <i class="icon-home"></i>Overview </a>
                                </li>
                                <li>
                                    <a href="extra_profile_account.html">
                                    <i class="icon-settings"></i> Follow </a>
                                </li>
                                <li>
                                    <a href="page_todo.html" target="_blank">
                                    <i class="icon-earphones-alt"></i> Calls </a>
                                </li>
                            </ul>
                        </div>
                        <!-- END MENU -->
                    </div>
                    <!-- END PORTLET MAIN -->
                </div>
            </div>
            <div class="col-md-8" style="width: 78%">
                <div class="col-md-6">
                    <!-- BEGIN PORTLET -->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-bar-chart theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Has Property</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row number-stats margin-bottom-30">
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="stat-left">
                                        <div class="stat-chart">
                                            <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                            <div id="sparkline_bar"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                        </div>
                                        <div class="stat-number">
                                            <div class="title">
                                                 Total
                                            </div>
                                            <div class="number">
                                                 246
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="stat-right">
                                        <div class="stat-chart">
                                            <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                            <div id="sparkline_bar2"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                        </div>
                                        <div class="stat-number">
                                            <div class="title">
                                                 New
                                            </div>
                                            <div class="number">
                                                 719
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="stat-left">
                                        <div class="stat-chart">
                                            <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                            <div id="sparkline_bar"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                        </div>
                                        <div class="stat-number">
                                            <div class="title">
                                                 Total
                                            </div>
                                            <div class="number">
                                                 246
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-xs-6">
                                    <div class="stat-right">
                                        <div class="stat-chart">
                                            <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                            <div id="sparkline_bar2"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                        </div>
                                        <div class="stat-number">
                                            <div class="title">
                                                 New
                                            </div>
                                            <div class="number">
                                                 719
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- END PORTLET -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
