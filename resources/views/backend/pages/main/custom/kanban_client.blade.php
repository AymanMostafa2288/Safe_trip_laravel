@extends('backend.layouts.'.config('var.dashboard_theme').'.index')

@section('style_url')
<link rel="stylesheet" type="text/css" href="{{ config('var.dashboard_theme_dist') }}/kanban/style.css">
@endsection
@section('style_in_page')
@endsection
@section('script_url')
<script src="{{ config('var.dashboard_theme_dist') }}/kanban/script2.js"></script>
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
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content">
		<!-- BEGIN PAGE HEAD -->
		<div class="page-head">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				{{-- <h1>{{ $config['main_title'] }}</h1> <small>{{ $config['sub_title'] }}</small></h1> --}}
                <h1>{{ $config['main_title'] }}</h1></h1>
			</div>
			<!-- END PAGE TITLE -->
		</div>
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<a href="{{ route('main_dashboard') }}">Dashboard</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				<a>{{ $config['main_title'] }}</a>
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
			<li><a href="{{ route($breadcrumb['route']) }}{{ $sting_query }}">{{ $breadcrumb['title'] }}</a></li>
			@endforeach
		</ul>
		<!-- END PAGE HEAD -->

        <div class="row">
            <div class="col-md-12">
                @if (checkAdminPermission(27, "insert"))
                    <a href="{{ route("crm_clients.create") }}"  class="btn btn-success">Add New Client</a>
                @endif

            </div>
        </div>




        <div class="kanban">
                @foreach ($stages as $stage_key=>$stage)
                    <div class="kanban-list" ondrop="drop(event)" ondragover="allowDrop(event)" data-id="{{ $stage_key }}">
                        <div class="kanban-list-header">
                            <h4>{{ $stage }}</h4>
                        </div>

                        @foreach ($clients as $client)


                            @if($client->status == $stage_key)

                                @php
                                    if($client->type=='salver'){
                                        $color='blue';
                                    }elseif($client->type=='golden'){
                                        $color='green';
                                    }
                                @endphp

                                <div class="kanban-item-container" draggable="true" ondragstart="drag(event)" data-id="{{ $client->id }}" >
                                    <div class="portlet box {{ $color }}">
                                        <div class="portlet-title">
                                            <div class="caption">

                                                Name: {{ $client->name }}<hr>
                                                @if ($client->email)
                                                    Email: {{ $client->email }}<hr>
                                                @endif
                                                @if ($client->phone)
                                                    Phone: {{ $client->phone }}<hr>
                                                @endif



                                            </div>
                                            <div class="tools">


                                                @if (checkAdminPermission(27, "show"))
                                                    <a href="{{ url("dashboard/modules/crm_clients/") }}/{{ $client->id }}" data-original-title="Show Details" title="Show Details">
                                                        <span aria-hidden="true" class="icon-eye" style="color: white;"></span>
                                                    </a>
                                                @endif
                                                {{-- @if (checkAdminPermission(27, "delete"))
                                                    <a href="javascript:;" class="collapse" data-original-title="Delete" title="Delete">
                                                        <span aria-hidden="true" class="icon-trash" style="color: white;"></span>
                                                    </a>
                                                @endif --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach

            </div>

        <!-- MODAL -->






	</div>
</div>
<!-- END CONTENT -->
@endsection
