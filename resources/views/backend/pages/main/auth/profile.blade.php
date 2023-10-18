@extends('backend.layouts.'.config('var.dashboard_theme').'.index')

@section('style_url')
<link rel="stylesheet" href="{{ config('var.dashboard_theme_dist') }}/global/plugins/leafletjs/leaflet.css" />
<link href="{{ config('var.dashboard_theme_dist') }}/global/plugins/leafletjs/leaflet-geocoder-locationiq.min.css" rel="stylesheet">
@endsection
@section('style_in_page')
@endsection
@section('script_url')
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/leafletjs/leaflet.js"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/leafletjs/leaflet-geocoder-locationiq.min.js"></script>
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
		if($("#multi_upload").length > 0){
			$("#multi_upload").pekeUpload();
		}

    });

</script>


@endsection
@section('script_in_page_custom')
    <script>
		if($("#multi_upload").length > 0){

			var plugin_path='{{ config("var.dashboard_theme_dist") }}/global/plugins/leafletjs/';
			var access_token='pk.eyJ1IjoiYXltYW5iYXNzaW9ueSIsImEiOiJja3lpZDJteXcxMmQ4MnBwMDhmbGxoaGo0In0.PnFAuQqx87kaMLkZIgeJCQ';
			var goLocation_accessToken='pk.4c3d7aafc80cd787595d5395ed3095fe';
			var map = L.map('map_leatflate').setView([26.549999, 31.700001], 10);
			var marker ='';
			L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token='+access_token, {
				attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
				maxZoom: 18,
				id: 'mapbox/streets-v11',
				tileSize: 512,
				zoomOffset: -1,
				accessToken: 'your.mapbox.access.token'
			}).addTo(map);


			var geocoderControlOptions = {
				position: 'topright',
				placeholder:'Search By Location',
				icon:plugin_path+'img/search_icon.png',
				title:'asdasdasd',
				markers:false,
				expanded: true,
       			panToPoint: true,
			}
			L.control.geocoder(goLocation_accessToken,geocoderControlOptions).addTo(map).on('select',
			function (e) {
				if(marker!=''){
					map.removeLayer(marker);
				}
				setMarker(e.latlng.lat,e.latlng.lng)
			});
			function setMarker(lat,lng){
				marker=L.marker([lat, lng],{
					draggable:true,
				}).addTo(map).on('dragend',
				function (e) {
					var latLng=e.target._latlng.lat+','+e.target._latlng.lng;
					$('#map_leatflate_latLng').val(latLng);
				});
				var latLng=lat+','+lng;
				$('#map_leatflate_latLng').val(latLng);
			}

		}

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
					<h1>{{ $config['main_title'] }}</h1> <small>{{ $config['sub_title'] }}</small></h1>
				</div>
				<!-- END PAGE TITLE -->
			</div>
			<!-- END PAGE HEAD -->
			<!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb hide">
				<li>
					<a href="javascript:;">Home</a><i class="fa fa-circle"></i>
				</li>
				<li class="active">
					 Dashboard
				</li>
			</ul>
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row margin-top-10">
				{!! $form !!}
			</div>

			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END CONTENT -->


@endsection
