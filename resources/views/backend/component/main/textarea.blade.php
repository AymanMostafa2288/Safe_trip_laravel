@isset($around_div)
<div class="{{ $around_div }}">
@endisset
@if (isset($summernote) && $summernote==true)
@isset($title)
<label>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',@$title) }}</label>
@endisset
<textarea name="{{ $name }}" id="summernote_1">
    {!! old(@$name,@$value) !!}
</textarea>
@else
<textarea class="form-control {{ @$class }}"
    @if(isset($readonly) && $readonly==true)
        readonly
    @endif
    @isset($attributes)
        @foreach ($attributes as $attr_key => $attr)
            {{ $attr_key }} = {{ $attr }}
        @endforeach
    @endisset
    name="{{ $name }}"
    placeholder="{{ @$placeholder }}"
    >{{ old(@$name,@$value) }}</textarea>
    @isset($title)
    <label>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',@$title) }}</label>
    @endisset
@endif




    @if(isset($repeater))
        @isset($validation_title)
            <p style="padding-top: 15px; color:red" id="{{ $validation_title }}_validation" data-code="{{ $validation_num }}"><span class="label label-danger"></span></p>
        @endisset
    @else
        <p style="padding-top: 15px; color:red" id="{{ $name }}_validation"><span class="label label-danger"></span></p>
    @endif
    @isset($below_div)
    <span style="color:red">{!! $below_div !!}</span>
    @endisset
@isset($around_div)
</div>
@endisset



