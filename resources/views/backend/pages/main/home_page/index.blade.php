@extends('backend.layouts.'.config('var.dashboard_theme').'.index')

@section('style_url')
@endsection
@section('style_in_page')
@endsection
@section('script_url')
<script src="{{ config('var.dashboard_theme_dist') }}/chart.min.js"></script>
@endsection
@section('script_in_page')
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
        Demo.init(); // init demo features
        Index.init(); // init index page
        Tasks.initDashboardWidget(); // init tash dashboard widget
    });

//     var xValues = ["Whatsapp", "Phone"];
//     var yValues = [55, 49];
//     var barColors = [
//         "#b91d47",
//         "#00aba9",
//     ];

//     new Chart("myChart", {
//         type: "pie",
//         data: {
//             labels: xValues,
//             datasets: [{
//             backgroundColor: barColors,
//             data: yValues
//             }]
//         },
//         options: {
//             title: {
//             display: true,
//             text: "Usage Ratio"
//             }
//         }
//     });
// </script>
@endsection
@section('page_title')
<title>{{ appSettings('app_name') }} |  {{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Dashboard') }}</title>
@endsection
@section('page_content')

    	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Dashboard') }} <small>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','statistics & reports') }}</small></h1>
				</div>
				<!-- END PAGE TITLE -->

			</div>
			<!-- END PAGE HEAD -->
			<!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb hide">
				<li>
					<a href="javascript:;">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Dashboard') }} <small>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Home') }}</a><i class="fa fa-circle"></i>
				</li>
				<li class="active">
					{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Dashboard') }} <small>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Dashboard') }}
				</li>
			</ul>
			<!-- END PAGE BREADCRUMB -->

            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="row margin-top-10">
                @foreach (counterData() as $counter)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        {!! viewComponents('dashboard_number_box',[
                            'icon'=>$counter['icon'],
                            'number'=>$counter['number'],
                            'title'=>$counter['title'],

                        ]) !!}
                    </div>
                @endforeach
            </div>
            <!-- END PAGE CONTENT INNER -->
            <!-- Chart piee -->
            @if (array_key_exists('pie',$charts))
                <div class="row margin-top-10">

                    @foreach ($charts['pie'] as $key_chart=>$chart)
                        <div class="col-md-6">
                            <div class="portlet box red">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bar-chart"></i> {{ $key_chart }}
                                    </div>

                                </div>
                                <div class="portlet-body">


                                    {!! $chart->container() !!}

                                    <script src="{{ $chart->cdn() }}"></script>

                                    {{ $chart->script() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- End Chart piee -->
            <!-- Chart Bar -->
            @if (array_key_exists('bar',$charts))
                <div class="row margin-top-10">

                    @foreach ($charts['bar'] as $key_chart=>$chart)
                        <div class="col-md-12">
                            <div class="portlet box red">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bar-chart"></i> {{ $key_chart }}
                                    </div>

                                </div>
                                <div class="portlet-body">


                                    {!! $chart->container() !!}

                                    <script src="{{ $chart->cdn() }}"></script>

                                    {{ $chart->script() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- End Bar piee -->
            <div class="row margin-top-10">
                <div class="col-md-6">
                    @foreach (reportsLinks('home_page','left') as $id=>$counter)
                        @php
                            $table=homePageReport($id);
                            reportsLinks('home_page')
                        @endphp
                        <div class="col-md-12">
                            <div class="portlet box red">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bar-chart"></i> {{ $counter }}
                                    </div>

                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            @foreach ($table['head'] as $head)
                                                <th style="text-align: center;">{{ $head }}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($table['body']) < 1)
                                                @php
                                                    $count_head=count($table['head'])+1;
                                                @endphp
                                                <tr class="odd gradeX">
                                                    <th colspan="{{ $count_head }}">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','No Data Found') }}</th>
                                                </tr>
                                            @endif

                                            @foreach($table['body'] as $body)
                                                <tr>
                                                    @foreach($table['head'] as $head)
                                                        <td style="text-align: center;"><h5 style="font-weight: 900;font-size: 15px;">{{ $body->$head }}</h5></td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-6">
                    @foreach (reportsLinks('home_page','right') as $id=>$counter)
                    @php
                        $table=homePageReport($id);
                        reportsLinks('home_page')
                    @endphp
                        <div class="col-md-12">
                            <div class="portlet box red">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bar-chart"></i> {{ $counter }}
                                    </div>

                                </div>
                                <div class="portlet-body">
                                    <div class="table-scrollable">
                                        <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            @foreach ($table['head'] as $head)
                                                <th style="text-align: center;">{{ $head }}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($table['body']) < 1)
                                                @php
                                                    $count_head=count($table['head'])+1;
                                                @endphp
                                                <tr class="odd gradeX">
                                                    <th colspan="{{ $count_head }}">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','No Data Found') }}</th>
                                                </tr>
                                            @endif

                                            @foreach($table['body'] as $body)
                                                <tr>
                                                    @foreach($table['head'] as $head)
                                                        <td style="text-align: center;"><h5 style="font-weight: 900;font-size: 15px;">{{ $body->$head }}</h5></td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
		</div>
	</div>
	<!-- END CONTENT -->


@endsection
