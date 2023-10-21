
@isset($start_row)
    <div class="row" style="    margin-bottom: 15px;">
@endisset
@isset($around_div)
<div class="{{ $around_div }}">
@endisset
@isset($repeater)
    @isset($title)
        <p  style=" font-size: 14px;color: #2b4a5c;font-weight: 600;margin-top: 15px">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$title) }}</p>
    @endisset
@endisset

<select class="form-control {{ @$class }}" data-placeholder="{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$placeholder) }}" name="{{ $name }}" tabindex="1"
    @isset($attributes))
        @foreach ($attributes as $attr_key => $attr)
            {{ $attr_key }} = {{ $attr }}
        @endforeach
    @endisset
    @isset($type)
        @if(in_array($type,['multi_select','multi_select_search']))
            multiple="multiple"
        @endif
    @endisset
    @isset($depends_by)
    main_attr='depends_by';
    @endisset
    placeholder="{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$placeholder) }}"
    >

    <option @if($selected == '') selected @endif>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$placeholder) }}</option>
    @foreach ($options as $key=>$value)
        @if(isset($type))
            @if(in_array($type,['multi_select','multi_select_search']))
                <option value="{{ $key }}" @if(in_array($key,$selected)) selected @endif>{{ $value }}</option>
            @else
                <option value="{{ $key }}" @if($key == $selected) selected @endif>{{ $value }}</option>
            @endif
        @else
            <option value="{{ $key }}" @if($key == $selected && $selected != '') selected @endif>{{ $value }}</option>
        @endif

    @endforeach
</select>
    @if(!isset($repeater))
        @isset($title)
            <label for="form_control_1">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$title) }}</label>
        @endisset
            <p style="padding-top: 15px; color:red" id="{{ $name }}_validation"><span class="label label-danger"></span></p>
    @else
        @isset($validation_title)
            <p style="color:red" id="{{ $validation_title }}_validation" data-code="{{ $validation_num }}" class="validate_area"><span class="label label-danger"></span></p>
        @endisset
    @endif


@isset($below_div)
    <span style="color:red">{!! $below_div !!}</span>
    @endisset
@isset($around_div)
</div>
@endisset
@isset($end_row)
    </div>
@endisset

