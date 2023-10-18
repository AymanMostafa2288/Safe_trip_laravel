@extends('backend.layouts.'.config('var.dashboard_theme').'.index')

@section('style_url')
@endsection
@section('style_in_page')
<style>
    label{
        margin-left: 20px;
    }
    th{
        text-align: center;
    }
    td{
        text-align: center;
    }
    table{
        color: black;
    }
</style>
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
<title>{{ appSettings('app_name') }} | {{ $config['main_title'] }}</title>
@endsection
@section('page_content')

<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
		<!-- BEGIN PAGE HEAD -->
		<div class="page-head">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$config['main_title']) }}</h1> <small>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$config['sub_title']) }}</small></h1>
			</div>
			<!-- END PAGE TITLE -->
		</div>

		<div class="page-breadcrumb breadcrumb">
			<li>
				<a href="{{ route('main_dashboard') }}">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Dashboard') }}</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				<a>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$config['main_title']) }}</a>
				<i class="fa fa-circle"></i>
			</li>


			@foreach ($config['breadcrumb'] as $breadcrumb)
			<li><a href="{{ route($breadcrumb['route']) }}">{{ $breadcrumb['title'] }}</a></li>
			@endforeach
            <li>
				<a>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$config['sub_title']) }}</a>
			</li>
		</ul>
		<!-- END PAGE HEAD -->

		<!-- BEGIN PAGE CONTENT INNER -->
		<div class="row margin-top-10">
            <div class="portlet box yellow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart"></i> {{ $config['sub_title'] }}
                    </div>
                </div>
                <div class="portlet-body">
                    <form action="{{ $config['url'] }}" method="GET">
                        <div class="row">
                            @if (array_key_exists('filter',$form))
                                @foreach ($form['filter'] as $key=>$value)
                                    {!! viewComponents($value['input_type'],$value) !!}
                                @endforeach
                            @endif
                        </div>
                        <div class="row" style="margin-top: 20px">
                            <hr>
                            <div class="col-md-12">
                                <button type="submit" class="btn yellow">filter</button>
                                {{-- <button type="submit" name="export_excel" class="btn green">Export Excel</button>
                                <button type="submit" name="export_pdf" class="btn blue">Export Pdf</button> --}}
                            </div>
                        </div>
                    </form>

                </div>

            </div>
		</div>

        <div class="row margin-top-10">
            @foreach (counterData(null,$config['id']) as $counter)
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    {!! viewComponents('dashboard_number_box',[
                            'icon'=>$counter['icon'],
                            'number'=>$counter['number'],
                            'title'=>$counter['title'],
                        ])
                     !!}
                </div>
            @endforeach

        </div>
        <div class="row">

            @component('backend.component.main.table_report',[
                'name'=>$config['sub_title'],'heads'=>$table['head'],'rows'=>$table['body'],'is_main'=>true,'color'=>'red'
            ])
            @endcomponent
        </div>
        <div class="row margin-top-10">
            <div class="col-md-6">
                @foreach (reportsLinks('with_report','left',$config['id']) as $id=>$counter)
                    @php
                        if(empty($_GET)){
                            $table=homePageReport($id,false);
                        }else{
                            $table=homePageReport($id,true);
                        }

                    @endphp
                    @component('backend.component.main.table_report',[
                        'name'=>$counter,'heads'=>$table['head'],'rows'=>$table['body'],'is_main'=>true,'color'=>'red'
                    ])
                    @endcomponent
                @endforeach
            </div>
            <div class="col-md-6">
                @foreach (reportsLinks('with_report','right',$config['id']) as $id=>$counter)
                    @php
                        if(empty($_GET)){
                            $table=homePageReport($id,false);
                        }else{
                            $table=homePageReport($id,true);
                        }

                    @endphp
                    @component('backend.component.main.table_report',[
                        'name'=>$counter,'heads'=>$table['head'],'rows'=>$table['body'],'is_main'=>true,'color'=>'red'
                    ])
                    @endcomponent

                @endforeach
            </div>
            <div class="col-md-12">
                @foreach (reportsLinks('with_report','full',$config['id']) as $id=>$counter)
                    @php
                        if(empty($_GET)){
                            $table=homePageReport($id,false);
                        }else{
                            $table=homePageReport($id,true);
                        }

                    @endphp
                    @component('backend.component.main.table_report',[
                        'name'=>$counter,'heads'=>$table['head'],'rows'=>$table['body']
                    ])
                    @endcomponent
                @endforeach
            </div>

        </div>



		<!-- END PAGE CONTENT INNER -->
	</div>
</div>
<!-- END CONTENT -->
@endsection

