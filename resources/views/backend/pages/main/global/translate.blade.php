@extends('backend.layouts.'.config('var.dashboard_theme').'.index')

@section('style_url')
<link rel="stylesheet" type="text/css" href="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-summernote/summernote.css">
@endsection
@section('style_in_page')
@endsection
@section('script_url')
<script src="{{ config('var.dashboard_theme_dist') }}global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
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
        ComponentsEditors.init();
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
					<h1>{{ $config['main_title'] }}</h1>
				</div>
				<!-- END PAGE TITLE -->
			</div>
			<!-- END PAGE HEAD -->
			<!-- BEGIN PAGE BREADCRUMB -->
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
				<li><a href="{{ route($breadcrumb['route'],$breadcrumb['params']) }}">{{ $breadcrumb['title'] }}</a><i class="fa fa-circle"></i></li>
				@endforeach
			</ul>
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row margin-top-10">
                <form action="{{ $config['action'] }}" method="POST" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-9">
                        @foreach ($config['langs'] as $langs)
                            <div class="portlet light form-fit">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject font-green-sharp bold uppercase">{{ $langs->name }}</span>
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse">
                                        </a>
                                    </div>
                                </div>

                                <div class="portlet-body form">
                                    @foreach ($config['fields'] as $field)
                                    @php
                                        $data=[];
                                    @endphp
                                    @if(!empty($config['data']))
                                        @php
                                            $data=$config['data'][$langs->slug];
                                        @endphp
                                    @endif
                                    <div class="form-group">
                                        <label class="control-label col-md-2">{{ $field->show_as }}</label>

                                            @if (in_array($field->type,['text_area','text_editor']))
                                                {!! viewComponents(
                                                    'textarea',[
                                                        'type'=>$field->type,
                                                        'name'=>$langs->slug.'['.$field->name.']',
                                                        'attributes'=>['rows'=>6],
                                                        'summernote'=>(isset($field->summernote))?true:false,
                                                        'title'=>'',
                                                        'class'=>($field->type=='text_editor')?'ckeditor':'',
                                                        'placeholder'=>$field->show_as,
                                                        'around_div'=>'col-md-9',
                                                        'value'=>(array_key_exists($field->name,$data))?$data[$field->name]:''
                                                    ])
                                                !!}
                                            @else
                                                {!! viewComponents(
                                                    'input',[
                                                        'type'=>$field->type,
                                                        'name'=>$langs->slug.'['.$field->name.']',
                                                        'title'=>'',
                                                        'class'=>'',
                                                        'placeholder'=>$field->show_as,
                                                        'around_div'=>'col-md-9',
                                                        'value'=>(array_key_exists($field->name,$data))?$data[$field->name]:''
                                                    ])
                                                !!}
                                            @endif

                                    </div>
                                    @endforeach

                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-3">
                        <div class="col-md-12">
                            <div class="portlet light">
                                <div class="portlet-body form" style="text-align: center;">
                                    <button type="submit" class="btn green" style="margin-top: 5px;">Translate</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
			</div>

			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END CONTENT -->

@endsection
