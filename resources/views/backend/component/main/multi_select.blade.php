

@isset($around_div)
<div class="{{ $around_div }}">
@endisset
<select class="form-control {{ @$class }}" data-placeholder="{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$placeholder) }}" name="{{ $name }}" tabindex="1"
    @isset($attributes))
        @foreach ($attributes as $attr_key => $attr)
            {{ $attr_key }} = {{ $attr }}
        @endforeach
    @endisset
    @isset($type)
        @if(in_array($type,['multi_select,multi_select_search']))
            multiple="multiple"
        @endif
    @endisset

    >
    <option value="">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$placeholder) }}</option>
    @foreach ($options as $key=>$value)
        @if(isset($type))
            @if(in_array($type,['multi_select,multi_select_search,tags']))
                <option value="{{ $key }}" @if(in_array($key,$selected)) selected @endif>{{ $value }}</option>
            @endif
        @else
            <option value="{{ $key }}" @if($key == $selected) selected @endif>{{ $value }}</option>
        @endif

    @endforeach
</select>
@isset($title)
<label for="form_control_1">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$title) }}</label>
@endisset
@isset($around_div)
</div>
@endisset
<p style="padding-top: 15px; color:red" id="{{ $name }}_validation"><span class="label label-danger"></p>
@isset($below_div)
{!! $below_div !!}
@endisset
