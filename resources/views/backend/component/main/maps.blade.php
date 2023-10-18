@isset($around_div)
<div class="{{ $around_div }}">
@endisset
<input type="hidden" id="map_leatflate_latLng" name="{{ $name }}" value="{{$value}}">
<div id='map_leatflate' style="width:100%;height:600px"></div>
@isset($around_div)
</div>
@endisset
<p style="padding-top: 15px; color:red" id="{{ $name }}_validation"><span class="label label-danger"></span></p>
@isset($below_div)
{!! $below_div !!}
@endisset
