@isset($start_row)
    <div class="row" style="    margin-bottom: 15px;">
@endisset
@isset($around_div)
<div class="{{ $around_div }}">
@endisset
    @isset($depends_on)
        @php
        $arr=explode("|",$depends_on);
        @endphp
        <div style='display:none' depends_on="{{ $arr[0] }}" depends_on_value="{{ $arr[1] }}">
    @endisset
            @isset($repeater)
                @isset($title)
                    <p  style=" font-size: 14px;color: #2b4a5c;font-weight: 600;margin-top: 15px">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$title) }}</p>
                @endisset
                @isset($validation_title)
                    <p style="color:red" id="{{ $validation_title }}_validation" data-code="{{ $validation_num }}" class="validate_area"><span class="label label-danger"></span></p>
                @endisset
            @endisset
            <input type="{{ @$type }}" class="form-control {{ @$class }}"
            @if(isset($readonly) && $readonly==true)
                readonly
            @endif
            @isset($placeholder))
                @if ($placeholder!='')
                    placeholder="{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$placeholder) }}"
                @endif

            @endisset
            @isset($attributes))
                @foreach ($attributes as $attr_key=> $attr)
                    {{ $attr_key }} = {{ $attr }}
                @endforeach
            @endisset
            name="{{ $name }}" value='{{ old(@$name,@$value) }}'>
            @if(!isset($repeater))
                @isset($title)
                    <label>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$title) }}</label>
                @endisset
                    <p style="padding-top: 15px; color:red" id="{{ $name }}_validation"><span class="label label-danger"></span></p>
            @endif
            @if(isset($below_div) && $below_div!='')
                <p style="padding-top: 15px;" ><span class="label label-info">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','Note') }}</span> {!! appendToLanguage(getDashboardCurrantLanguage(),'globals',$below_div) !!}</p>
            @endif
    @isset($depends_on)
        </div>
    @endisset
@isset($around_div)
</div>
@endisset
@isset($end_row)
    </div>
@endisset
